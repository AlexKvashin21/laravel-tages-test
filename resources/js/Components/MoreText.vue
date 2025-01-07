<script setup>
import {ref, computed, onMounted, useTemplateRef} from 'vue';

const props = defineProps({
    text: {
        type: String,
        required: true,
    },
});

const showMore = ref(false);
const isTruncate = ref(true);

const containerRef = useTemplateRef(`container`)
const textRef = useTemplateRef(`text`)

const textClass = computed(() => (!showMore.value && isTruncate.value ? 'break-all line-clamp-3' : 'break-all'));

const toggleText = () => {
    showMore.value = !showMore.value;
};

onMounted(() => {
    isTruncate.value = textRef.value.scrollHeight > containerRef.value.scrollHeight;
});

</script>

<template>
    <div ref="container" class="overflow-hidden">
        <p ref="text" :class="textClass">
            {{ text }}
        </p>
        <button v-if="!showMore && isTruncate" @click="toggleText" class="text-blue-500">
            читать далее...
        </button>
    </div>
</template>
