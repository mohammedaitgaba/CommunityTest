<template>
    <div class="login-page">
      <h1>Login</h1>
      <form>
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" v-model="email">
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" v-model="password">
        </div>
        <button class="btn" @click.prevent="login">Login</button>
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

  const email = ref('');
  const password = ref('');

  function login() {

      const formData = {
        email: email.value,
        password: password.value,
      }

    axios.post('http://127.0.0.1:8000/api/login',formData)
        .then(res=>{
          if (res.data) {
            localStorage.setItem('access_token',res.data.access_token);
            localStorage.setItem('id',res.data.id);
            router.push({ path: '/' })
            toaster.success(`Welcome back`);
          }
        })
        .catch(err=>{
          const error = err.response.data.message || err.message
          toaster.error(`error : ${error}`);
        })
  }
  </script>
  
  <style>
  .login-page {
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
  input[type="password"] {
    width: 100%;
    padding: 0.5rem;
    border: none;
    border-bottom: 2px solid #ddd;
    font-size: 1rem;
    font-weight: 400;
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