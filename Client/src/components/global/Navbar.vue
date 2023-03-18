<template>
    <nav>
      <div class="navbar-container">
        <router-link to="/" class="navbar-logo">
          Wide Community
        </router-link>
        <button class="navbar-toggle" @click=toggleNav>
          <span class="navbar-toggle-icon" ></span>
        </button>
        <ul class="navbar-menu" :class="{ 'navbar-menu-show': !showNavbar }">
          <li class="navbar-item">
            <router-link to="/" class="navbar-link">Home</router-link>
          </li>
          <li class="navbar-item">
            <router-link to="/Login" class="navbar-link">Login</router-link>
          </li>
          <li class="navbar-item">
            <router-link to="/Register" class="navbar-link">Register</router-link>
          </li>
        </ul>
      </div>
    </nav>
  </template>
  
  <script setup>
    import { ref } from 'vue';
      const showNavbar = ref([false])
        const toggleNav = ()=>{
            console.log(showNavbar.value);
            if (showNavbar.value==false) {
                showNavbar.value = true
            }else{
                showNavbar.value = false
            }
        }
  </script>
  
  <style>
  .navbar-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #fff;
    padding: 1rem;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }
  
  .navbar-logo {
    font-size: 1.5rem;
    font-weight: bold;
    color: #333;
    text-decoration: none;
  }
  
  .navbar-toggle {
    display: none;
    background-color: transparent;
    border: none;
    cursor: pointer;
    padding: 0.5rem;
  }
  
  .navbar-toggle-icon {
    display: block;
    width: 1.5rem;
    height: 2px;
    background-color: #333;
    position: relative;
  }
  
  .navbar-toggle-icon::before,
  .navbar-toggle-icon::after {
    content: "";
    display: block;
    width: 100%;
    height: 100%;
    background-color: #333;
    position: absolute;
    left: 0;
  }
  
  .navbar-toggle-icon::before {
    top: -0.5rem;
  }
  
  .navbar-toggle-icon::after {
    bottom: -0.5rem;
  }
  
  .navbar-menu {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    margin: 0;
    padding: 0;
    list-style: none;
  }
  
  .navbar-menu-show {
    display: flex;
    flex-direction: column;
    position: absolute;
    top: 4rem;
    right: 0;
    width: 100%;
    background-color: #fff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }
  
  .navbar-item {
    margin: 0;
    padding: 0;
  }
  
  .navbar-link {
    display: block;
    padding: 1rem;
    text-decoration: none;
    color: #333;
  }
  
  @media (max-width: 768px) {
    .navbar-toggle {
      display: block;
    }
    .navbar-menu {
      display: none;
    }
    .navbar-menu-show {
      position: static;
      flex-direction: column;
      width: auto;
      box-shadow: none;
    }
  }
  </style>
  