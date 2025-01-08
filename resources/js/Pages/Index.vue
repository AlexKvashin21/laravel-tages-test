<script setup>

import MainLayout from "@/Layouts/MainLayout.vue";
import {onBeforeMount, reactive, ref} from "vue";
import axios from "axios";
import {createToaster} from "@meforma/vue-toaster";
import {format} from "date-fns";
import {ru} from 'date-fns/locale';
import MoreText from "@/Components/MoreText.vue";
import Spinner from "@/Components/Spinner.vue";

const toaster = createToaster({
    position: 'top-right'
});

const categories = ref([])
const tweets = ref({})

const isLoadingSendMessage = ref(false)
const isLoadingTweets = ref(false)
const isLoadingCategories = ref(false)
const isLoadingMoreTweets = ref(false)

const page = ref(1)
const perPage = ref(10)

const form = reactive({
    category_id: 0,
    username: null,
    content: null,
});

const sendMessage = () => {
    if (form.category_id === 0) {
        return toaster.error('Выберете категорию!')
    }

    if (form.category_id && form.username && form.content && !isLoadingSendMessage.value) {
        isLoadingSendMessage.value = true

        axios.post(`/api/tweet`, form).then(res => {
            if (res) {
                toaster.success('Сообщение отправлено')
            }

            form.category_id = 0
            form.username = null
            form.content = null
        }).catch(err => {
            console.error(err)

            toaster.error('Произошла ошибка')
        }).finally(() => {
            isLoadingSendMessage.value = false;
        })
    }
}

const showMoreMessages = () => {
    page.value += 1

    isLoadingMoreTweets.value = true

    axios.get(`/api/tweet?per_page=${perPage.value}&page=${page.value}`).then(res => {
        tweets.value.data.push(...res.data.data)
        tweets.value.last_page = res.data.last_page
    }).catch(err => {
        console.error(err)
        page.value -= 1
    }).finally(() => {
        isLoadingMoreTweets.value = false;
    })
}

const formattedDate = (createdAt) => {
    return format(new Date(createdAt), 'd MMMM yyyy HH:mm', {locale: ru});
}

const getAllCategories = async () => {
    isLoadingCategories.value = true

    axios.get('api/category/all').then(res => {
        categories.value = res.data
    }).catch(err => {
        console.error(err)
    }).finally(() => {
        isLoadingCategories.value = false;
    })
}

const getTweets = async () => {
    isLoadingTweets.value = true

    await axios.get('api/tweet').then(res => {
        tweets.value = res.data
    }).catch(err => {
        console.error(err)
    }).finally(() => {
        isLoadingTweets.value = false;
    })
}

onBeforeMount(async () => {
    await getAllCategories()
    await getTweets()

    Echo.channel('tweet')
        .listen('.store.tweet', (res) => {
            tweets.value.data.unshift(res.tweet);
        });
})

</script>

<template>
    <MainLayout>

        <span class="relative flex justify-center mb-2 md:mb-4">
            <div
                class="absolute inset-x-0 top-1/2 h-px -translate-y-1/2 bg-transparent bg-gradient-to-r from-transparent via-gray-500 to-transparent opacity-75"/>
            <span class="relative z-10 bg-white px-6 text-2xl md:text-3xl xl:text-5xl font-light text-gray-800">
                Отправить сообщение
            </span>
        </span>

        <div
            class="mx-auto my-0 h-full w-full rounded-[10px] bg-white drop-shadow-[0px_1px_3px_rgba(0,0,0,0.1)] dark:bg-black-1">
            <div class="mx-auto rounded-lg p-4 max-[1600px]:scale-100 bg-white">
                <form @submit.prevent="sendMessage" class="flex flex-col space-y-4">
                    <select
                        v-model="form.category_id"
                        name="category"
                        id="category"
                        class="w-full rounded-lg border-gray-300 text-gray-700 sm:text-sm"
                        :disabled="categories.length < 1"
                    >
                        <option v-if="categories.length < 1" :value="0" disabled selected hidden>
                            Загрузка...
                        </option>
                        <option v-else :value="0" disabled selected hidden>
                            Выберите категорию
                        </option>
                        <option v-for="category in categories" :value="category.id">
                            {{ category.title }}
                        </option>
                    </select>

                    <label
                        for="username"
                        class="relative block rounded-md border border-gray-200 shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600"
                    >
                        <input
                            v-model="form.username"
                            type="text"
                            id="username"
                            class="w-full peer border-none bg-transparent placeholder-transparent focus:border-transparent focus:outline-none focus:ring-0"
                            placeholder="Имя"
                            required
                        />

                        <span
                            class="pointer-events-none absolute start-2.5 top-0 -translate-y-1/2 bg-white p-0.5 text-xs text-gray-700 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-sm peer-focus:top-0 peer-focus:text-xs"
                        >
                            Имя
                        </span>
                    </label>

                    <label
                        for="username"
                        class="relative block rounded-md border border-gray-200 shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600"
                    >
                        <input
                            v-model="form.content"
                            type="text"
                            id="message"
                            class="w-full peer border-none bg-transparent placeholder-transparent focus:border-transparent focus:outline-none focus:ring-0"
                            placeholder="Сообщение"
                            required
                        />

                        <span
                            class="pointer-events-none absolute start-2.5 top-0 -translate-y-1/2 bg-white p-0.5 text-xs text-gray-700 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-sm peer-focus:top-0 peer-focus:text-xs"
                        >
                            Сообщение
                        </span>
                    </label>

                    <button
                        type="submit"
                        class="w-fit inline-block rounded border border-indigo-600 px-12 py-3 text-sm font-medium text-indigo-600 hover:bg-indigo-600 hover:text-white focus:outline-none focus:ring active:bg-indigo-500"
                        :disabled="isLoadingSendMessage"
                    >
                        {{ isLoadingSendMessage ? 'Загрузка' : 'Отправить' }}
                    </button>
                </form>
            </div>
        </div>


        <span class="relative flex justify-center my-2 md:my-4">
            <div
                class="absolute inset-x-0 top-1/2 h-px -translate-y-1/2 bg-transparent bg-gradient-to-r from-transparent via-gray-500 to-transparent opacity-75"/>
            <span class="relative z-10 bg-white px-6 text-2xl md:text-3xl xl:text-5xl font-light text-gray-800">
                Твиты
            </span>
        </span>

        <div v-if="isLoadingTweets">
            <Spinner class="w-[50px] mx-auto"/>
        </div>

        <div v-else-if="tweets?.data?.length > 0" class="flex flex-col space-y-2">

            <article
                class="rounded-lg border border-gray-100 bg-white p-4 shadow-sm transition hover:shadow-lg sm:p-6 overflow-hidden "
                v-for="tweet in tweets.data"
                :key="`tweet-${tweet.id}`"
            >
                <div class="rounded-[10px] bg-white">
                    <time datetime="2022-10-10" class="block text-xs text-gray-500">
                        {{ formattedDate(tweet.created_at) }}
                    </time>


                    <h3 class="mt-0.5 text-lg text-gray-900">
                        Автор:
                        <span class="font-medium underline">
                            {{ tweet.username }}
                        </span>
                    </h3>

                    <MoreText :text="tweet.content"/>

                    <div class="mt-3 flex flex-wrap gap-1">
                       <span class="whitespace-nowrap rounded-full bg-purple-100 px-2.5 py-0.5 text-xs text-purple-600">
                           {{ tweet.category }}
                       </span>
                    </div>
                </div>
            </article>
        </div>

        <h3 v-else class="text-center text-3xl">Твитов пока нет!</h3>

        <div class="flex justify-center">
            <button
                v-if="tweets.last_page > page"
                @click.prevent="showMoreMessages"
                :disabled="isLoadingMoreTweets"
                class="mt-2 md:mt-4 inline-block rounded border border-indigo-600 px-12 py-3 text-sm font-medium text-indigo-600 hover:bg-indigo-600 hover:text-white focus:outline-none focus:ring active:bg-indigo-500"
            >
                {{ isLoadingMoreTweets ? 'Загрузка' : 'Больше' }}
            </button>
        </div>

    </MainLayout>
</template>

