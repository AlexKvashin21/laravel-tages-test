<script setup>

import MainLayout from "@/Layouts/MainLayout.vue";
import {useForm} from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import {reactive, ref} from "vue";

const props = defineProps({
    categories: {
        type: Array,
    },
    tweets: {
        type: Array,
    },
});

const form = reactive({
    category_id: null,
    username: null,
    content: null,
});

const sendMessage = () => {
    console.log(form)

    axios.post('/store', form).then( res => {
        props.tweets.unshift(res.data)
    })
}

</script>

<template>
    <MainLayout>
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

                <button type="submit" class="btn btn-primary">Отправить</button>
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
