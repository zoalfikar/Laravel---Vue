<template>
  <fieldset class="mb-4">
    <div>
        <legend class="text-base font-medium text-gray-900">
            {{index + 1}}.{{question.question}}
        </legend>
        <p class="text-sm text-gray-500">{{question.description}}</p>
    </div>
    <div class="mt-3">
        <div v-if="question.type === 'select'">
            <select :value="modelValue" @change="emits('update:modelValue',$event.target.value)" class="mt-1 block py-2 px-3 w-full sm:text-sm text-gray-900 bg-white rounded-md shadow-sm border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 border-gray-600  focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Please Select</option>
                <option v-for="option in question.data.options" :value="option.text" :key="option.uuid">
                    {{option.text}}
                </option>
            </select>

        </div>
        <div v-else-if="question.type === 'radio'">
            <div v-for="(option , ind) of question.data.options" :key="option.uuid"  class="flex items-center">
                <input type="radio" :name="'question'+question.id" :value="option.text" @change="emits('update:modelValue',$event.target.value)" :id="option.uuid" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                <label :for="option.uuid" class="ml-3 block text-sm font-medium text-gray-700">
                    {{option.text}}
                </label>
            </div>

        </div>
        <div v-else-if="question.type === 'checkbox'">
            <div v-for="(option , ind) of question.data.options" :key="option.uuid"  class="flex items-center">
                <input type="checkbox" v-model="model[option.text]"   @change="checkboxChange" :id="option.uuid" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                <label :for="option.uuid" class="ml-3 block text-sm font-medium text-gray-700">
                    {{option.text}}
                </label>
            </div>

        </div>
        <div v-else-if="question.type === 'text'">
            <input type="text" :value="modelValue" @input="emits('update:modelValue',$event.target.value)" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

        </div>
        <div v-else-if="question.type === 'textarea'">
            <textarea :value="modelValue" @input="emits('update:modelValue',$event.target.value)" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>

        </div>

    </div>

  </fieldset>
  <hr class="mb-4" />
</template>

<script setup>
import { ref } from "@vue/reactivity";

   const { question ,index, modelValue} = defineProps({
        question : Object,
        index : Number,
        modelValue : [ String , Array],
    });

    const emits = defineEmits(["update:modelValue"]);

    let model ;
    if (question.type === "checkbox") {
        model = ref({});
    }

    function checkboxChange($event) {
        const selectedOptions = [];
        for (let text in model.value) {

            if (model.value[text]) {
                selectedOptions.push(text);
            }
        }
        emits("update:modelValue" , selectedOptions);
    }


</script>

<style>

</style>
