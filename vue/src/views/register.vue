<template>
      <div>
        <img class="mx-auto h-12 w-auto" src="https://tailwindui.com/img/logos/workflow-mark.svg?color=indigo&shade=600" alt="Workflow" />
        <h2 class="mt-6 text-center text-3xl tracking-tight font-bold text-gray-900">register</h2>
        <p class="mt-2 text-center text-sm text-gray-600">
          Or
          {{ ' ' }}
          <router-link :to="{name:'Login'}" class="font-medium text-indigo-600 hover:text-indigo-500"> login to your page </router-link>
        </p>
      </div>
      <form class="mt-8 space-y-6" @submit="register">
        <input type="hidden" name="remember" value="true" />
        <div class="rounded-md shadow-sm -space-y-px">
          <div>
            <label for="fullname" class="sr-only">Fullname</label>
            <input id="fullname" name="name" type="text" v-model="user.name" autocomplete="name" required="" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Full Name" />
          </div>
           <div>
            <label for="email-address" class="sr-only">Email address</label>
            <input id="email-address" name="email" type="email" v-model="user.email" autocomplete="email" required="" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900  focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Email address" />
          </div>
          <div>
            <label for="password" class="sr-only">Password</label>
            <input id="password" name="password" type="password" v-model="user.password" autocomplete="current-password" required="" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900  focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Password" />
          </div>
          <div>
            <label for="password_confirmation" class="sr-only">Password Confirmation</label>
            <input id="password_confirmation" name="password_confirmation" type="password" v-model="user.password_confirmation" autocomplete="current-password_confirmation" required="" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Password Confirmation" />
          </div>

        </div>



        <div>
          <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
              <LockClosedIcon class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" aria-hidden="true" />
            </span>
            Sign up
          </button>
        </div>
      </form>

</template>

<script setup>
import { LockClosedIcon } from "@heroicons/vue/outline";
import { useRouter } from "vue-router";
import store from "../store";
const user = {
    name: '',
    email: '',
    password: '',
    password_confirmation: '',

}
const router = useRouter()
function register(ev) {
    ev.preventDefault();
    store.dispatch('register',user).then((res)=>{router.push({name:'Dashboard'})})

}
</script>

<style>

</style>
