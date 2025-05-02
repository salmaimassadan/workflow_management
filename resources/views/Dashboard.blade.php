@extends('layout')

@section('title', 'Dashboard')
@section('breadcrumb', 'Home')

@section('content')
<style>
    /* Style pour les informations de la boîte */
.box-info {
    display: flex;
    justify-content: space-around;
    margin-bottom: 20px;
}

.box-info li {
    list-style: none;
    background: #fff;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    text-align: center;
    flex: 1;
    margin: 0 10px;
}

.box-info i {
    font-size: 2em;
    margin-bottom: 10px;
}

.box-info .text h3 {
    margin: 0;
    font-size: 1.5em;
}

.box-info .text p {
    margin: 0;
    color: #666;
}

/* Style pour les données du tableau */
.table-data {
    margin-top: 20px;
}

.table-data .order, .table-data .todo {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.table-data .order .head, .table-data .todo .head {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.table-data .order table {
    width: 100%;
    border-collapse: collapse;
}

.table-data .order th, .table-data .order td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
    text-align: left;
}

.table-data .order th {
    background-color: #f4f4f4;
}

/* Style pour les statuts */
.status {
    display: inline-block;
    padding: 0.3em 0.6em;
    border-radius: 0.25em;
    color: #fff;
    font-size: 0.75em;
}

.status.urgent {
    background-color: red;
}

.status.traité {
    background-color: green;
}

.status.non-lu {
    background-color: blue !important;
}

.status.lu {
    background-color: orange;
}

.status.archivé {
    background-color: gray;
}

/* Style pour les todo items */
.todo-list {
    list-style: none;
    padding: 0;
}

.todo-list li {
    padding: 10px;
    border-bottom: 1px solid #ddd;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.todo-list li.completed {
    background-color: #d4edda;
    color: #155724;
}

.todo-list li.not-completed {
    background-color: #f8d7da;
    color: #721c24;
}

.todo-list i {
    font-size: 1.2em;
}

/* Style pour le formulaire de recherche et filtrage */
.filter-form {
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.filter-form input, .filter-form select, .filter-form button {
    padding: 8px;
}

.filter-form button {
    padding: 8px 12px;
}
.todo-table {
    width: 100%;
    border-collapse: collapse;
}

.todo-table th, .todo-table td {
    border: 1px solid #ddd;
    padding: 8px;
}

.todo-table th {
    background-color: #f2f2f2;
    text-align: left;
}

.completed {
    background-color: #d4edda;
}

.not-completed {
    background-color: #f8d7da;
}

</style>

<div class="box-info">
    <li>
        <a href="{{ route('employees.index') }}">
            <i class='bx bxs-calendar-check'></i>
            <span class="text">
                <h3>{{ $userCount }}</h3>
                <p>Users</p>
            </span>
        </a>
    </li>
    <li>
        <a href="{{ route('courriers.index') }}">
            <i class='bx bxs-group'></i>
            <span class="text">
                <h3>{{ $courrierCount }}</h3>
                <p>Courriers</p>
            </span>
        </a>
    </li>
    <li>
        <a href="{{ route('services.index') }}">
            <i class='bx bxs-dollar-circle'></i>
            <span class="text">
                <h3>{{ $serviceCount }}</h3>
                <p>Services</p>
            </span>
        </a>
    </li>
</div>

<div class="table-data">
    <div class="order">
        <div class="head">
            <h3>Recent Courriers</h3>
            <form id="filter-form" method="GET" action="{{ route('dashboard') }}" class="filter-form">
                <input type="text" name="search" placeholder="Search by reference..." value="{{ request('search') }}">
                <select name="status">
                    <option value="">All status</option>
                    <option value="urgent" {{ request('status') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                    <option value="traité" {{ request('status') == 'traité' ? 'selected' : '' }}>Completed</option>
                    <option value="non lu" {{ request('status') == 'non lu' ? 'selected' : '' }}>Unread</option>
                    <option value="lu" {{ request('status') == 'lu' ? 'selected' : '' }}>Read</option>
                    <option value="archivé" {{ request('status') == 'archivé' ? 'selected' : '' }}>Archived</option>
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
                    @foreach($courriers as $courrier)
                        <tr>
                            <td>{{ $courrier->reference }}</td>
                            <td>{{ $courrier->created_at->format('d-m-Y') }}</td>
                            <td><span class="status {{ $courrier->status }}">{{ ucfirst($courrier->status) }}</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        function fetchResults(page = 1) {
            let formData = $('#filter-form').serialize() + `&page=${page}`;
            $.ajax({
                url: $('#filter-form').attr('action'),
                method: 'GET',
                data: formData,
                beforeSend: function() {
                    $('#loading-spinner').show(); // Ensure you have this element in your view
                },
                success: function(response) {
                    $('tbody').html($(response).find('tbody').html());
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error: ", status, error);
                },
                complete: function() {
                    $('#loading-spinner').hide(); // Ensure you have this element in your view
                }
            });
        }

        $('#filter-form input, #filter-form select').on('change keyup', function() {
            fetchResults();
        });

        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            let page = $(this).attr('href').split('page=')[1];
            fetchResults(page);
        });

        fetchResults();
    });
</script>

@endsection