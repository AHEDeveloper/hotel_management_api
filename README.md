# 🏨 Stayly API

> A RESTful hotel booking API built with Laravel, designed to handle hotel rooms, reservations, authentication, permissions, payments, and automated booking workflows.

## ✨ Features

- 🔐 **Multi Authentication**
    - Separate authentication for **Super Admin** and **Admin**
    - Customer authentication and booking flow

- 🛡️ **Role & Permission Management**
    - Role-based access control for the admin panel
    - Powered by **Spatie Laravel Permission**

- 🛏️ **Room Management**
    - Hotel room management with room images
    - Image handling using **Intervention Image**

- 📅 **Reservation System**
    - Reservation based on customer-selected dates
    - Automatic calculation of the reservation price based on the number of nights

- 💳 **Online Payment**
    - **Zibal** payment gateway
    - Integrated using **Shetabit Multipay**

- 🔔 **Automatic Payment Reminder**
    - A Laravel **Job** handles unpaid reservations
    - Customers are notified when they have **10 minutes remaining** to complete their payment
    - Unpaid reservations are automatically cancelled after the payment deadline

## 🛠️ Tech Stack

- PHP
- Laravel
- MySQL
- RESTful API
- Spatie Laravel Permission
- Intervention Image
- Shetabit Multipay
- Zibal Payment Gateway
- Laravel Jobs

## 🎯 Project Goal

Stayly API is a hotel booking backend project focused on implementing real-world hotel reservation logic, authentication, authorization, image management, payment processing, and automated workflows using Laravel.

---

Made with ❤️ and Laravel.
