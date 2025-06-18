# Mini Chat API (Laravel 12)

This is a RESTful API built with Laravel 12 for a mini chat application. It supports user authentication, friend management, and more.

## 🚀 Technologies

-   Laravel 12
-   Sanctum for API authentication
-   MySQL
-   Redis
-   Docker (recommended for development)
-   Postman (for API testing)

---

## 📌 Base URL

<a href="https://k22cnt3_project4_minichat.test">https://k22cnt3_project4_minichat.test</a>

## 👾 End Point

# Login

-   POST api/v1/login
-   Allow user can login to use the application
-   Create Bearer token to access the application

# Register

# Friend list

GET|HEAD api/v1/friends
This End point allow to get list friend of Current User base on Bearer Token Created by Login
