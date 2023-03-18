<template>
    <div class="Register-page">
      <h1>Register</h1>
      <form>
        <div class="form-group">
          <label for="nom">nom</label>
          <input type="string" id="nom" v-model="nom">
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" v-model="email">
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" v-model="password">
        </div>
        <div class="form-group">
          <label for="password_confirmation">Password Confirmation</label>
          <input type="password" id="password_confirmation" v-model="password_confirmation">
        </div>
        <div class="error" v-if="errorMessage">
            {{ errorMessage }}
        </div>
        <button class="btn" @click.prevent="Register">Register</button>
      </form>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import axios from 'axios'
  import { createToaster } from "@meforma/vue-toaster";
  import { useRouter } from "vue-router";
  const router = useRouter();

  const toaster = createToaster({ position:"top" });

  const nom = ref('');
  const email = ref('');
  const password = ref('');
  const password_confirmation = ref('');

  const errorMessage = ref('');

  function Register() {
    const formData = {
      name: nom.value,
      email: email.value,
      password: password.value,
      password_confirmation: password_confirmation.value
  }
        // verivify password confirmation 
    if (formData.password !==formData.password_confirmation) {
        errorMessage.value = 'Please confirme your password'
    }else{
        errorMessage.value = ''
        axios.post('http://127.0.0.1:8000/api/register',formData)
        .then(res=>{
          if (res.data) {
            router.push({ path: '/Login' })
            toaster.success(`${res.data.message}`);
          }
        })
        .catch(err=>{
          const error = err.response.data.message || err.message
          toaster.error(`error : ${error}`);
        })
    }

  }
  </script>
  
  <style>
  .Register-page {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100vh;
    background-color: #f2f2f2;
  }
  
  h1 {
    margin-bottom: 1rem;
    font-size: 2rem;
    font-weight: 500;
  }
  
  form {
    display: flex;
    flex-direction: column;
    width: 300px;
    padding: 2rem;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }
  
  .form-group {
    margin-bottom: 1rem;
  }
  
  label {
    display: block;
    margin-bottom: 0.5rem;
    font-size: 1rem;
    font-weight: 500;
    color: #333;
  }
  
  input[type="email"],
  input[type="string"],
  input[type="password"] {
    width: 100%;
    padding: 0.5rem;
    border: none;
    border-bottom: 2px solid #ddd;
    font-size: 1rem;
    font-weight: 400;
  }
  .error{
    color: red;
  }
  
  button.btn {
    margin-top: 1rem;
    padding: 0.5rem;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    font-size: 1rem;
    font-weight: 500;
    cursor: pointer;
  }
  
  button.btn:hover {
    background-color: #0069d9;
  }
  </style>