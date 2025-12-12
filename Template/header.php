<!DOCTYPE html>
<html>
<head>
<title>Praktikum 11 - PHP - OOP | Routing</title>
<style>
/* Style Umum */
body { 
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
    margin: 0; 
    padding: 0;
    background-color: #f4f4f9; 
    color: #333;
}
h1 {
    color: #007bff;
    padding: 15px 20px;
    margin-top: 0;
    background-color: #ffffff;
    border-bottom: 3px solid #007bff;
}
hr {
    border: 0;
    border-top: 1px solid #ccc;
    margin: 20px 0;
}
.main-container {
    display: flex;
    padding: 20px;
}

/* Sidebar Styling */
.sidebar { 
    width: 200px; 
    padding-right: 20px; 
    border-right: 1px solid #ddd; 
    background-color: #ffffff;
    height: 100vh; /* Agar tinggi sidebar memenuhi viewport */
    padding-top: 10px;
}
.sidebar h3 {
    color: #007bff;
    border-bottom: 1px solid #eee;
    padding-bottom: 5px;
}
.sidebar ul {
    list-style: none;
    padding: 0;
}
.sidebar li a {
    text-decoration: none;
    color: #333;
    display: block;
    padding: 8px 0;
    border-radius: 4px;
    transition: background-color 0.3s;
}
.sidebar li a:hover {
    background-color: #e9ecef;
    color: #007bff;
}

/* Content Area */
.content { 
    flex-grow: 1; /* Mengisi sisa ruang */
    padding-left: 30px; 
}
h2 {
    color: #343a40;
    border-bottom: 2px solid #f8f9fa;
    padding-bottom: 10px;
}

/* Table Styling */
table { 
    border-collapse: collapse; 
    width: 100%; 
    margin-top: 15px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    background-color: #ffffff;
}
thead th { 
    background-color: #007bff; 
    color: white; 
    padding: 12px; 
    border: 1px solid #007bff;
}
td { 
    padding: 10px; 
    border: 1px solid #ddd; 
}
tbody tr:nth-child(even) {
    background-color: #f8f9fa;
}
tbody tr:hover {
    background-color: #e9ecef;
}

/* Button Styling */
.btn { 
    text-decoration: none; 
    padding: 8px 15px; 
    border-radius: 5px; 
    display: inline-block; 
    margin: 2px 5px 2px 0; 
    font-weight: bold;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s, opacity 0.3s;
}
.btn-primary { 
    background-color: #007bff; 
    color: white; 
}
.btn-primary:hover {
    background-color: #0056b3;
}
.btn-danger { 
    background-color: #dc3545; 
    color: white; 
}
.btn-danger:hover {
    background-color: #c82333;
}
.btn-success {
    background-color: #28a745; 
    color: white; 
}
.btn-success:hover {
    background-color: #1e7e34; 
}

/* Alert Styling */
.alert { 
    padding: 15px; 
    margin-bottom: 20px; 
    border-radius: 5px;
    border: 1px solid transparent; 
}
.alert-danger { 
    color: #721c24; 
    background-color: #f8d7da; 
    border-color: #f5c2c7; 
}
.alert-success {
    color: #155724;
    background-color: #d4edda;
    border-color: #c3e6cb;
}
/* Style untuk flash message di index.php */
p[style*="background-color: #e9ffe9"] {
    /* Mengganti flash message lama dengan alert-success */
    border: 1px solid #c3e6cb !important;
    background-color: #d4edda !important;
    color: #155724 !important;
    padding: 15px !important;
    border-radius: 5px;
    margin-bottom: 15px;
}
</style>
</head>
<body>
<header>
    <h1>Aplikasi Sederhana OOP & Routing</h1>
</header>

<div class="main-container">

<?php include TEMPLATE_PATH . "sidebar.php"; ?>

<div class="content">
