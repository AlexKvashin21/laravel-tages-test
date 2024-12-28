<script setup>

import MainLayout from "@/Layouts/MainLayout.vue";
import {onMounted, reactive, ref} from "vue";

const props = defineProps({
    categories: {
        type: Array,
    },
    tweets: {
        type: Array,
    },
});

const isLoading = ref(false)

const form = reactive({
    category_id: null,
    username: null,
    content: null,
});

const sendMessage = () => {
    if (form.category_id && form.username && form.content && !isLoading.value) {
        isLoading.value = true

        axios.post('/store', form).then( res => {
            props.tweets.unshift(res.data)

            isLoading.value = false
        }).catch(err => {
            console.error(err)

            isLoading.value = false
        })
    }
}

onMounted(() => {
    Echo.channel('tweet')
        .listen('.store.tweet', (res) => {
            const exists = props.tweets.some(obj => obj.id === res.tweet.id);

            if (!exists) {
                props.tweets.unshift(res.tweet);
            }
        });
})

</script>

<template>
    <MainLayout>

        <h2 class="mb-5 text-center text-5xl">Отправить сообщение</h2>

        <div class="flex flex-col space-y-1 border-2 border-black p-2">
            <form @submit.prevent="sendMessage">
                <div class="flex flex-col">
                    <label for="category">Категория</label>
                    <select v-model="form.category_id" id="category" name="category_id" class="form-control" required>
                        <option v-for="category in categories" :value="category.id">{{ category.title }}</option>
                    </select>
                </div>
                <label class="flex flex-col">
                    Имя
                    <input type="text" name="username" required v-model="form.username">
                </label>
                <label class="flex flex-col">
                    Сообщение
                    <input type="text" name="content" required v-model="form.content">
                </label>

                <button type="submit" class="mt-2 p-1 border-black border-2 btn btn-primary">{{isLoading ? 'Загрузка' : 'Отправить' }}  </button>
            </form>
        </div>

        <h2 class="my-5 text-center text-5xl">Твиты</h2>

        <div class="flex flex-col space-y-2">
            <div v-for="tweet in tweets" class="flex flex-col space-y-1 border-2 p-2 border-black">
                <div>
                    Категория: {{ tweet.category }}
                </div>
                <div>
                    Имя: {{ tweet.username }}
                </div>
                <div>
                    Сообщение: {{ tweet.content }}
                </div>
                <div>
                    Дата: {{ tweet.created_at }}
                </div>
            </div>
        </div>
    </MainLayout>
</template>

