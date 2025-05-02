@extends('secretary.layout')

@section('title', 'Dashboard')
@section('breadcrumb', 'Dashboard')

@section('content')
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<style>
        @import url('https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Poppins:wght@400;500;600;700&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Poppins:wght@400;500;600;700&display=swap');

* {
	margin: 0;
	padding: 0;
	box-sizing: border-box;
}

a {
	text-decoration: none;
}

li {
	list-style: none;
}

:root {
	--poppins: 'Poppins', sans-serif;
	--lato: 'Lato', sans-serif;

	--light: #F9F9F9;
	--blue: #3C91E6;
	--light-blue: #CFE8FF;
	--grey: #eee;
	--dark-grey: #AAAAAA;
	--dark: #342E37;
	--red: #DB504A;
	--yellow: #FFCE26;
	--light-yellow: #FFF2C6;
	--orange: #FD7238;
	--light-orange: #FFE0D3;
}

html {
	overflow-x: hidden;
}

body.dark {
	--light: #0C0C1E;
	--grey: #060714;
	--dark: #FBFBFB;
}

body {
	background: var(--grey);
	overflow-x: hidden;
}





/* SIDEBAR */
#sidebar {
	position: fixed;
	top: 0;
	left: 0;
	width: 280px;
	height: 100%;
	background: var(--light);
	z-index: 2000;
	font-family: var(--lato);
	transition: .3s ease;
	overflow-x: hidden;
	scrollbar-width: none;
}
#sidebar::--webkit-scrollbar {
	display: none;
}
#sidebar.hide {
	width: 60px;
}
#sidebar .brand {
	font-size: 24px;
	font-weight: 700;
	height: 56px;
	display: flex;
	align-items: center;
	color: var(--blue);
	position: sticky;
	top: 0;
	left: 0;
	background: var(--light);
	z-index: 500;
	padding-bottom: 20px;
	box-sizing: content-box;
}
#sidebar .brand .bx {
	min-width: 60px;
	display: flex;
	justify-content: center;
}
#sidebar .side-menu {
	width: 100%;
	margin-top: 48px;
}
#sidebar .side-menu li {
	height: 48px;
	background: transparent;
	margin-left: 6px;
	border-radius: 48px 0 0 48px;
	padding: 4px;
}
#sidebar .side-menu li.active {
	background: var(--grey);
	position: relative;
}
#sidebar .side-menu li.active::before {
	content: '';
	position: absolute;
	width: 40px;
	height: 40px;
	border-radius: 50%;
	top: -40px;
	right: 0;
	box-shadow: 20px 20px 0 var(--grey);
	z-index: -1;
}
#sidebar .side-menu li.active::after {
	content: '';
	position: absolute;
	width: 40px;
	height: 40px;
	border-radius: 50%;
	bottom: -40px;
	right: 0;
	box-shadow: 20px -20px 0 var(--grey);
	z-index: -1;
}
#sidebar .side-menu li a {
	width: 100%;
	height: 100%;
	background: var(--light);
	display: flex;
	align-items: center;
	border-radius: 48px;
	font-size: 16px;
	color: var(--dark);
	white-space: nowrap;
	overflow-x: hidden;
}
#sidebar .side-menu.top li.active a {
	color: var(--blue);
}
#sidebar.hide .side-menu li a {
	width: calc(48px - (4px * 2));
	transition: width .3s ease;
}
#sidebar .side-menu li a.logout {
	color: var(--red);
}
#sidebar .side-menu.top li a:hover {
	color: var(--blue);
}
#sidebar .side-menu li a .bx {
	min-width: calc(60px  - ((4px + 6px) * 2));
	display: flex;
	justify-content: center;
}
/* SIDEBAR */





/* CONTENT */
#content {
	position: relative;
	width: calc(100% - 280px);
	left: 280px;
	transition: .3s ease;
}
#sidebar.hide ~ #content {
	width: calc(100% - 60px);
	left: 60px;
}




/* NAVBAR */
#content nav {
	height: 56px;
	background: var(--light);
	padding: 0 24px;
	display: flex;
	align-items: center;
	grid-gap: 24px;
	font-family: var(--lato);
	position: sticky;
	top: 0;
	left: 0;
	z-index: 1000;
}
#content nav::before {
	content: '';
	position: absolute;
	width: 40px;
	height: 40px;
	bottom: -40px;
	left: 0;
	border-radius: 50%;
	box-shadow: -20px -20px 0 var(--light);
}
#content nav a {
	color: var(--dark);
}
#content nav .bx.bx-menu {
	cursor: pointer;
	color: var(--dark);
}
#content nav .nav-link {
	font-size: 16px;
	transition: .3s ease;
}
#content nav .nav-link:hover {
	color: var(--blue);
}
#content nav form {
	max-width: 400px;
	width: 100%;
	margin-right: auto;
}
#content nav form .form-input {
	display: flex;
	align-items: center;
	height: 36px;
}
#content nav form .form-input input {
	flex-grow: 1;
	padding: 0 16px;
	height: 100%;
	border: none;
	background: var(--grey);
	border-radius: 36px 0 0 36px;
	outline: none;
	width: 100%;
	color: var(--dark);
}
#content nav form .form-input button {
	width: 36px;
	height: 100%;
	display: flex;
	justify-content: center;
	align-items: center;
	background: var(--blue);
	color: var(--light);
	font-size: 18px;
	border: none;
	outline: none;
	border-radius: 0 36px 36px 0;
	cursor: pointer;
}
#content nav .notification {
	font-size: 20px;
	position: relative;
}
#content nav .notification .num {
	position: absolute;
	top: -6px;
	right: -6px;
	width: 20px;
	height: 20px;
	border-radius: 50%;
	border: 2px solid var(--light);
	background: var(--red);
	color: var(--light);
	font-weight: 700;
	font-size: 12px;
	display: flex;
	justify-content: center;
	align-items: center;
}
#content nav .profile img {
	width: 36px;
	height: 36px;
	object-fit: cover;
	border-radius: 50%;
}
#content nav .switch-mode {
	display: block;
	min-width: 50px;
	height: 25px;
	border-radius: 25px;
	background: var(--grey);
	cursor: pointer;
	position: relative;
}
#content nav .switch-mode::before {
	content: '';
	position: absolute;
	top: 2px;
	left: 2px;
	bottom: 2px;
	width: calc(25px - 4px);
	background: var(--blue);
	border-radius: 50%;
	transition: all .3s ease;
}
#content nav #switch-mode:checked + .switch-mode::before {
	left: calc(100% - (25px - 4px) - 2px);
}
/* NAVBAR */





/* MAIN */
#content main {
	width: 100%;
	padding: 36px 24px;
	font-family: var(--poppins);
	max-height: calc(100vh - 56px);
	overflow-y: auto;
}
#content main .head-title {
	display: flex;
	align-items: center;
	justify-content: space-between;
	grid-gap: 16px;
	flex-wrap: wrap;
}
#content main .head-title .left h1 {
	font-size: 36px;
	font-weight: 600;
	margin-bottom: 10px;
	color: var(--dark);
}
#content main .head-title .left .breadcrumb {
	display: flex;
	align-items: center;
	grid-gap: 16px;
}
#content main .head-title .left .breadcrumb li {
	color: var(--dark);
}
#content main .head-title .left .breadcrumb li a {
	color: var(--dark-grey);
	pointer-events: none;
}
#content main .head-title .left .breadcrumb li a.active {
	color: var(--blue);
	pointer-events: unset;
}
#content main .head-title .btn-download {
	height: 36px;
	padding: 0 16px;
	border-radius: 36px;
	background: var(--blue);
	color: var(--light);
	display: flex;
	justify-content: center;
	align-items: center;
	grid-gap: 10px;
	font-weight: 500;
}




#content main .box-info {
	display: grid;
	grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
	grid-gap: 24px;
	margin-top: 36px;
}
#content main .box-info li {
	padding: 24px;
	background: var(--light);
	border-radius: 20px;
	display: flex;
	align-items: center;
	grid-gap: 24px;
}
#content main .box-info li .bx {
	width: 80px;
	height: 80px;
	border-radius: 10px;
	font-size: 36px;
	display: flex;
	justify-content: center;
	align-items: center;
}
#content main .box-info li:nth-child(1) .bx {
	background: var(--light-blue);
	color: var(--blue);
}
#content main .box-info li:nth-child(2) .bx {
	background: var(--light-yellow);
	color: var(--yellow);
}
#content main .box-info li:nth-child(3) .bx {
	background: var(--light-orange);
	color: var(--orange);
}
#content main .box-info li .text h3 {
	font-size: 24px;
	font-weight: 600;
	color: var(--dark);
}
#content main .box-info li .text p {
	color: var(--dark);	
}





#content main .table-data {
	display: flex;
	flex-wrap: wrap;
	grid-gap: 24px;
	margin-top: 24px;
	width: 100%;
	color: var(--dark);
}
#content main .table-data > div {
	border-radius: 20px;
	background: var(--light);
	padding: 24px;
	overflow-x: auto;
}
#content main .table-data .head {
	display: flex;
	align-items: center;
	grid-gap: 16px;
	margin-bottom: 24px;
}
#content main .table-data .head h3 {
	margin-right: auto;
	font-size: 24px;
	font-weight: 600;
}
#content main .table-data .head .bx {
	cursor: pointer;
}

#content main .table-data .order {
	flex-grow: 1;
	flex-basis: 500px;
}
#content main .table-data .order table {
	width: 100%;
	border-collapse: collapse;
}
#content main .table-data .order table th {
	padding-bottom: 12px;
	font-size: 13px;
	text-align: left;
	border-bottom: 1px solid var(--grey);
}
#content main .table-data .order table td {
	padding: 16px 0;
}
#content main .table-data .order table tr td:first-child {
	display: flex;
	align-items: center;
	grid-gap: 12px;
	padding-left: 6px;
}
#content main .table-data .order table td img {
	width: 36px;
	height: 36px;
	border-radius: 50%;
	object-fit: cover;
}
#content main .table-data .order table tbody tr:hover {
	background: var(--grey);
}
#content main .table-data .order table tr td .status {
	font-size: 10px;
	padding: 6px 16px;
	color: var(--light);
	border-radius: 20px;
	font-weight: 700;
}
#content main .table-data .order table tr td .status.completed {
	background: var(--blue);
}
#content main .table-data .order table tr td .status.process {
	background: var(--yellow);
}
#content main .table-data .order table tr td .status.pending {
	background: var(--orange);
}


#content main .table-data .todo {
	flex-grow: 1;
	flex-basis: 300px;
}
#content main .table-data .todo .todo-list {
	width: 100%;
}
#content main .table-data .todo .todo-list li {
	width: 100%;
	margin-bottom: 16px;
	background: var(--grey);
	border-radius: 10px;
	padding: 14px 20px;
	display: flex;
	justify-content: space-between;
	align-items: center;
}
#content main .table-data .todo .todo-list li .bx {
	cursor: pointer;
}
#content main .table-data .todo .todo-list li.completed {
	border-left: 10px solid var(--blue);
}
#content main .table-data .todo .todo-list li.not-completed {
	border-left: 10px solid var(--orange);
}
#content main .table-data .todo .todo-list li:last-child {
	margin-bottom: 0;
}
/* MAIN */
/* CONTENT */









@media screen and (max-width: 768px) {
	#sidebar {
		width: 200px;
	}

	#content {
		width: calc(100% - 60px);
		left: 200px;
	}

	#content nav .nav-link {
		display: none;
	}
}



/* Container for the dropdown */
.dropdown {
    position: relative;
    display: inline-block;
}

/* Content of the dropdown (hidden by default) */
.dropdown-content {
    display: none;
    position: absolute;
    right: 0; /* Align dropdown content to the right */
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
}

/* Links inside the dropdown */
.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

/* Show the dropdown content when hovering over the profile image */
.dropdown:hover .dropdown-content {
    display: block;
}

/* Change color of dropdown links on hover */
.dropdown-content a:hover {
    background-color: #f1f1f1;
}

/* Ensure the profile image and dropdown container are aligned */
.profile {
    display: flex;
    align-items: center;
    cursor: pointer;
}



@media screen and (max-width: 576px) {
	#content nav form .form-input input {
		display: none;
	}

	#content nav form .form-input button {
		width: auto;
		height: auto;
		background: transparent;
		border-radius: none;
		color: var(--dark);
	}

	#content nav form.show .form-input input {
		display: block;
		width: 100%;
	}
	#content nav form.show .form-input button {
		width: 36px;
		height: 100%;
		border-radius: 0 36px 36px 0;
		color: var(--light);
		background: var(--red);
	}

	#content nav form.show ~ .notification,
	#content nav form.show ~ .profile {
		display: none;
	}

	#content main .box-info {
		grid-template-columns: 1fr;
	}

	#content main .table-data .head {
		min-width: 420px;
	}
	#content main .table-data .order table {
		min-width: 420px;
	}
	#content main .table-data .todo .todo-list {
		min-width: 420px;
	}
/*dark mode*/
.switch-mode {
    display: inline-block;
    width: 60px;
    height: 34px;
    background-color: #ccc;
    border-radius: 34px;
    position: relative;
    cursor: pointer;
    transition: background-color 0.3s;
}

.switch-mode::before {
    content: "";
    position: absolute;
    top: 4px;
    left: 4px;
    width: 26px;
    height: 26px;
    background-color: white;
    border-radius: 50%;
    transition: transform 0.3s;
}

/* Change switch appearance when checked */
#switch-mode:checked + .switch-mode {
    background-color: #4CAF50;
}

#switch-mode:checked + .switch-mode::before {
    transform: translateX(26px);
}

/* Dark mode styles */
.dark-mode {
    background-color: #333;
    color: #fff;
}

/* Example of dark mode styling for other elements */
.dark-mode #sidebar {
    background: #1a1a1a;
}

.dark-mode #content {
    background: #1a1a1a;
}

.dark-mode .box-info li {
    background-color: #444;
    color: #ddd;
}

.dark-mode .table-data {
    background-color: #444;
}



.side-menu {
    list-style-type: none;
    padding: 0;
}

.side-menu > li {
    margin: 15px 0;
    cursor: pointer;
    display: flex;
    align-items: center;
}

.side-menu > li > i {
    margin-right: 10px;
}

.side-menu ul {
    list-style-type: none;
    padding-left: 20px;
    display: none;
}

.side-menu ul li {
    margin: 10px 0;
    display: flex;
    align-items: center;
}

.side-menu ul li i {
    margin-right: 8px;
}

.side-menu ul li a {
    text-decoration: none;
    color: inherit;
    display: flex;
    align-items: center;
}

.side-menu ul li a:hover {
    color: #007bff;
}

.side-menu ul li.active a {
    color: #007bff;
    font-weight: bold;
}

.side-menu ul li.active i {
    color: #007bff;
}

}
.notification-item {
    padding: 10px;
    border-bottom: 1px solid #e0e0e0;
}

.unread {
    background-color: #f9f9f9;
    font-weight: bold;
}

.notification-title {
    margin: 0;
    font-size: 14px;
}

.notification-time {
    font-size: 12px;
    color: #999;
}

.no-notifications {
    padding: 10px;
    text-align: center;
    color: #999;
}
/* Container for the dropdown */
.notification-dropdown {
    position: relative;
    display: inline-block;
}

/* Content of the dropdown (hidden by default) */
.notification-dropdown .dropdown-content {
    display: none;
    position: absolute;
    background-color: white;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
    width: 250px;
    right: 0;
}

/* Show the dropdown content when hovering over the notification */
.notification-dropdown:hover .dropdown-content {
    display: block;
}

/* Change color of dropdown links on hover */
.dropdown-content a:hover {
    background-color: #ddd;
}


    </style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.11.0/echo.iife.js"></script>

	<title>AdminC2M</title>
</head>
<body>


		<!-- MAIN -->
		<main>
			
                <div class="table-data">
    <div class="order">
        <div class="head">
            <h3>Recent Courriers</h3>
            <form id="filter-form" method="GET" action="{{ route('secretary.dashboard') }}" class="filter-form">
                <input type="text" name="search" placeholder="Search by reference..." value="{{ request('search') }}">
                <select name="status">
                    <option value="">All status</option>
                    <option value="urgent" {{ request('status') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="unread" {{ request('status') == 'unread' ? 'selected' : '' }}>Unread</option>
                    <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Read</option>
                    <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                </select>
                <input type="date" name="date" value="{{ request('date') }}">
            </form>
        </div>
        <div class="order-content">
            <table>
                <thead>
                    <tr>
                        <th>Reference</th>
                        <th>Date Courrier</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($notifications as $notification)
                        <tr>
                            <td>{{ $notification->courrier->reference }}</td>
                            <td>{{ $notification->courrier->created_at->format('d-m-Y') }}</td>
                            <td><span class="status {{ $notification->courrier->status }}">{{ ucfirst($notification->courrier->status) }}</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="todo">
        <div class="head">
            <h3>Todos</h3>
            <i class='bx bx-plus'></i>
            <i class='bx bx-filter'></i>
        </div>
        <ul class="todo-list">
            <li class="completed">
                <p>Todo List</p>
                <i class='bx bx-dots-vertical-rounded'></i>
            </li>
            <li class="completed">
                <p>Todo List</p>
                <i class='bx bx-dots-vertical-rounded'></i>
            </li>
            <li class="not-completed">
                <p>Todo List</p>
                <i class='bx bx-dots-vertical-rounded'></i>
            </li>
            <li class="completed">
                <p>Todo List</p>
                <i class='bx bx-dots-vertical-rounded'></i>
            </li>
            <li class="not-completed">
                <p>Todo List</p>
                <i class='bx bx-dots-vertical-rounded'></i>
            </li>
        </ul>
    </div>
</div>

			</div>

			@yield('content')
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->

	<script>
        const allSideMenu = document.querySelectorAll('#sidebar .side-menu.top li a');

        allSideMenu.forEach(item=> {
            const li = item.parentElement;

            item.addEventListener('click', function () {
                allSideMenu.forEach(i=> {
                    i.parentElement.classList.remove('active');
                })
                li.classList.add('active');
            })
        });

        // TOGGLE SIDEBAR
        const menuBar = document.querySelector('#content nav .bx.bx-menu');
        const sidebar = document.getElementById('sidebar');

        menuBar.addEventListener('click', function () {
            sidebar.classList.toggle('hide');
        });	
    </script>
    @endsection
