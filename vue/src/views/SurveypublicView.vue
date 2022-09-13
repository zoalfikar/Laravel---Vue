<template>
  <div class="py-5 px-8">
    <div v-if="loading" class="flex justify-center">loading...</div>
    <form @submit.prevent="submitSurvey" v-else class="container mx-auto">
        <div class="item-center grid grid-cols-6">
            <div class="mr-4">
                <img :src="survey.image_url" >
            </div>
            <div class="col-span-5">
                <h1 class="text-3xl mb-3">{{survey.title}}</h1>
                <p class="text-gary-500 text-sm" v-html="survey.description"></p>

            </div>

        </div>
        <div v-if="surveyFinished" class="py-8 px-6 bg-emerald-400 text-white w-[600px] mx-auto">
            <div class="text-xl mb-3 font-semibold">
                Thank you for participating in this survey.
            </div>
            <button type="button" @click="submitAnotherResponse" class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">
               Submit another response
            </button>

        </div>
        <div v-else>
            <hr class="my-3" />
            <div v-for="(question,ind) in survey.questions" :key="question.id">
                <QuestionViewer v-model="answers[question.id]" :question="question" :index="ind" />

            </div>
            <button type="submit" class="focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900">Submit</button>
        </div>
    </form>
  </div>
</template>

<script setup>
import { computed, ref } from '@vue/runtime-core';
import { useRoute } from 'vue-router';
import QuestionViewer from '../components/viewer/QuistionViewer.vue';
import store from '../store';
const route = useRoute();
const loading = computed(()=>store.state.currentSurvey.loading);
const survey = computed(() => store.state.currentSurvey.data);
const surveyFinished = ref(false);

const answers =ref({});

store.dispatch("getSurveyBySlug",route.params.slug);

function submitSurvey() {
    console.log(JSON.stringify(answers.value,undefined,2));
    store.dispatch("saveSurveyAnswer",{
        surveyId : survey.value.id ,
        answers : answers.value,
    }).then(
        (response)=>{
            if (response.status === 201) {
                surveyFinished.value=true;


            }
        }
    )

}

function submitAnotherResponse() {
    answers.value={};
    surveyFinished.value=false;


}

</script>

<style>

</style>
