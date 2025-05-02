@extends('secretary.layout')

@section('title', 'Courriers')
@section('breadcrumb', 'My Courriers')

@section('content')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="_token" content="{{ csrf_token() }}" />
    <title>Courriers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.7.2/font/bootstrap-icons.min.css">
    <style>
        .form-input {
            display: flex;
            align-items: center;
            height: 36px;
            flex-grow: 1;
            padding: 0 16px;
            border: none;
            background: #f1f1f1;
            border-radius: 36px 0 0 36px;
            outline: none;
            width: 100%;
            color: #333;
        }

        .form-input input[type="search"] {
            flex-grow: 1;
            border: none;
            outline: none;
            background: transparent;
            color: #333;
            font-size: 18px;
        }

        .search-btn {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 36px;
            height: 100%;
            border-radius: 0 36px 36px 0;
            background: #007bff;
            color: #fff;
            border: none;
            outline: none;
            cursor: pointer;
        }

        .btn-download {
            display: inline-flex;
            align-items: center;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
        }

        .btn-download:hover {
            background-color: #0056b3;
        }

        .btn-download i {
            margin-right: 8px;
        }

        .btn-count {
            display: flex;
            align-items: center;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 50px;
            padding: 10px 20px;
            margin: 5px;
            font-size: 16px;
            text-decoration: none;
            transition: background-color 0.3s, transform 0.3s;
        }

        .btn-count i {
            margin-right: 8px;
        }

        .btn-count:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        .btn-count.read {
            background-color: #28a745;
        }

        .btn-count.read:hover {
            background-color: #218838;
        }

        .btn-count.unread {
            background-color: #ffc107;
        }

        .btn-count.unread:hover {
            background-color: #e0a800;
        }

        .btn-count.urgent {
            background-color: #dc3545;
        }

        .btn-count.urgent:hover {
            background-color: #c82333;
        }

        .btn-count.archived {
            background-color: #6c757d;
        }

        .btn-count.archived:hover {
            background-color: #5a6268;
        }

        .btn-count.completed {
            background-color: #17a2b8;
        }

        .btn-count.completed:hover {
            background-color: #117a8b;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="row" style="margin:20px;">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h2>My Courriers</h2>
                    </div>
                    <div class="d-flex mb-3">
                        <a href="#" class="btn btn-count">
                            <i class="bi bi-envelope-open"></i> Read: {{ $countRead }}
                        </a>
                        <a href="#" class="btn btn-count">
                            <i class="bi bi-envelope"></i> Unread: {{ $countUnread }}
                        </a>
                        <a href="#" class="btn btn-count">
                            <i class="bi bi-exclamation-circle"></i> Urgent: {{ $countUrgent }}
                        </a>
                        <a href="#" class="btn btn-count">
                            <i class="bi bi-archive"></i> Archived: {{ $countArchived }}
                        </a>
                        <a href="#" class="btn btn-count">
                            <i class="bi bi-check-circle"></i> Completed: {{ $countCompleted }}
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="d-flex mb-3">
                            <a href="{{ route('secretary.create') }}" class="btn btn-outline-dark btn-sm me-2" title="Add New Courrier">
                                <i class="bi bi-file-earmark-plus"></i> Add New Courrier
                            </a>
                            <!-- Search Form -->
<form id="searchForm" action="{{ route('secretary.index_2') }}" method="GET" class="flex-grow-1">
    <div class="form-input">
        <input type="search" name="search" placeholder="Search..." value="{{ request()->get('search') }}">
        <button type="submit" class="btn btn-primary">Search</button>
    </div>
</form>

<!-- Filter Form -->
<form id="filterForm" method="GET" action="{{ route('secretary.index_2') }}" class="filter-form">
    <select name="status" id="statusFilter" class="form-select">
        <option value="">All status</option>
        <option value="urgent" {{ request('status') == 'urgent' ? 'selected' : '' }}>Urgent</option>
        <option value="traité" {{ request('status') == 'traité' ? 'selected' : '' }}>Completed</option>
        <option value="non lu" {{ request('status') == 'non lu' ? 'selected' : '' }}>Unread</option>
        <option value="lu" {{ request('status') == 'lu' ? 'selected' : '' }}>Read</option>
        <option value="archivé" {{ request('status') == 'archivé' ? 'selected' : '' }}>Archived</option>
    </select>
</form>

<!-- Download PDF Button -->
<a href="{{ route('secretary.downloadPdf') }}" class="btn btn-download" id="downloadPdfButton">
    <i class="bi bi-cloud-download"></i>
    <span class="text">Download PDF</span>
</a>

                        </div>
                        <br/>
                        <div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Reference</th>
                <th>Content</th>
                <th>Subject</th>
                <th>Type</th>
                <th>Sender</th>
                <th>Recipient</th>
                <th>Document</th>
                <th>Status</th>
                <th>Added at</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Courriers from Notifications -->
            @foreach($notifications as $notification)
                <tr>
                    <td>{{ $notification->courrier->id }}</td>
                    <td>{{ $notification->courrier->reference }}</td>
                    <td>{{ $notification->courrier->content }}</td>
                    <td>{{ $notification->courrier->subject }}</td>
                    <td>{{ $notification->courrier->type }}</td>
                    <td>{{ $notification->courrier->sender }}</td>
                    <td>{{ $notification->courrier->recipient }}</td>
                    <td>
                        @if ($notification->courrier->document)
                            <a href="{{ asset('storage/' . $notification->courrier->document) }}" target="_blank">View Document</a>
                        @else
                            No Document
                        @endif
                    </td>
                    <td>{{ $notification->courrier->status }}</td>
                    <td>{{ $notification->courrier->created_at }}</td>
                    <td>
                        <a href="{{ route('secretary.show', $notification->courrier->id) }}" title="View Courrier">
                            <button class="btn btn-link btn-sm"><i class="bi bi-eye-fill"></i> View</button>
                        </a>
                        <a href="{{ route('secretary.edit', $notification->courrier->id) }}" title="Edit Courrier">
                            <button class="btn btn-outline-secondary btn-sm"><i class="bi bi-pencil-square"></i> Edit</button>
                        </a>
                        
                        <button type="button" class="btn btn-primary ms-2" data-bs-toggle="modal" data-bs-target="#sendModal" onclick="setFormAction({{ $notification->courrier->id }})">
                            <i class="bi bi-send"></i> Send Courrier
                        </button>
                    </td>
                </tr>
            @endforeach

            <!-- Courriers Created by the Employee -->
            @foreach($courriersCreatedByEmployee as $courrier)
                <tr>
                    <td>{{ $courrier->id }}</td>
                    <td>{{ $courrier->reference }}</td>
                    <td>{{ $courrier->content }}</td>
                    <td>{{ $courrier->subject }}</td>
                    <td>{{ $courrier->type }}</td>
                    <td>{{ $courrier->sender }}</td>
                    <td>{{ $courrier->recipient }}</td>
                    <td>
                        @if ($courrier->document)
                            <a href="{{ asset('storage/' . $courrier->document) }}" target="_blank">View Document</a>
                        @else
                            No Document
                        @endif
                    </td>
                    <td>{{ $courrier->status }}</td>
                    <td>{{ $courrier->created_at }}</td>
                    <td>
                        <a href="{{ route('courriers.show', $courrier->id) }}" title="View Courrier">
                            <button class="btn btn-link btn-sm"><i class="bi bi-eye-fill"></i> View</button>
                        </a>
                        <a href="{{ route('courriers.edit', $courrier->id) }}" title="Edit Courrier">
                            <button class="btn btn-outline-secondary btn-sm"><i class="bi bi-pencil-square"></i> Edit</button>
                        </a>
                        <form method="POST" action="{{ route('secretary.destroy', $courrier->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-outline-danger btn-sm" title="Delete Courrier" onclick="return confirm('Confirm delete?')">
                                <i class="bi bi-calendar2-x"></i> Delete
                            </button>
                        </form>
                        <button type="button" class="btn btn-primary ms-2" data-bs-toggle="modal" data-bs-target="#sendModal" onclick="setFormAction({{ $courrier->id }})">
                            <i class="bi bi-send"></i> Send Courrier
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $notifications->links('pagination::bootstrap-4') }}
    </div>


    <!-- Modal -->
    <div class="modal fade" id="sendModal" tabindex="-1" aria-labelledby="sendModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sendModalLabel">Send Courrier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <div class="modal-body">
                <form id="sendForm" action="{{ route('secretary.send', ['id' => $notification->courrier->id]) }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="service_id" class="form-label">Choisir un Service</label>
        <select id="service_id" name="service_id" class="form-select">
            <option value="">Sélectionnez un service</option>
            @foreach($services as $service)
                <option value="{{ $service->id }}">{{ $service->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="user_ids" class="form-label">Ou choisir des utilisateurs spécifiques</label>
        <select id="user_ids" name="user_ids[]" class="form-select" multiple>
            <!-- Les options seront ajoutées via AJAX -->
        </select>
    </div>
    <div class="mb-3">
        <label for="deadline" class="form-label">Deadline</label>
        <input type="date" id="deadline" name="deadline" class="form-control">
    </div>
    <div class="mb-3">
        <label for="read_status" class="form-label">Read Status</label>
        <select id="read_status" name="read_status" class="form-select">
            <option value="non lu">Unread</option>
            <option value="lu">Read</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="commentaire" class="form-label">Commentaire</label>
        <textarea id="commentaire" name="commentaire" class="form-control"></textarea>
    </div>
    <button type="submit" class="btn btn-primary" onclick="return confirm('Are you sure you want to send this courrier?')">Envoyer</button>
    </form>

                </div>
            </div>
        </div>
    </div>

    
        <script>document.addEventListener('DOMContentLoaded', function () {
    const searchForm = document.getElementById('searchForm');
    const searchInput = searchForm.querySelector('input[name="search"]');
    const filterForm = document.getElementById('filterForm');
    const statusFilter = document.getElementById('statusFilter');

    // Auto-submit filter form when status changes
    statusFilter.addEventListener('change', function () {
        filterForm.submit();
    });

    // Improve search flexibility with a delay before submitting
    let searchTimeout;
    searchInput.addEventListener('input', function () {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function () {
            searchForm.submit();
        }, 500);  // Adjust the delay as needed
    });
});

</script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
    // Auto-submit filter form when filter values change
    const filterForm = document.getElementById('filterForm');
    if (filterForm) {
        filterForm.querySelectorAll('select, input').forEach((input) => {
            input.addEventListener('change', () => {
                filterForm.submit(); // This triggers the form submission
            });
        });
    }
});

    </script>
    <script>
    

        // Auto-submit filter form when filter values change
        const filterForm = document.getElementById('filterForm');
        if (filterForm) {
            filterForm.querySelectorAll('select, input').forEach((input) => {
                input.addEventListener('change', () => filterForm.submit());
            });
        }
       
        // Fetch results and update table via AJAX
        function fetchResults(page = 1) {
            let formData = $('#filter-form').serialize() + `&page=${page}`;
            $.ajax({
                url: $('#filter-form').attr('action'),
                method: 'GET',
                data: formData,
                beforeSend: () => $('#loading-spinner').show(),
                success: (response) => {
                    $('tbody').html($(response).find('tbody').html());
                },
                error: (xhr, status, error) => console.error("AJAX Error: ", status, error),
                complete: () => $('#loading-spinner').hide(),
            });
        }

        $('#filter-form input, #filter-form select').on('change keyup', () => fetchResults());
        $(document).on('click', '.pagination a', function (event) {
            event.preventDefault();
            fetchResults($(this).attr('href').split('page=')[1]);
        });
</script>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        // Set form action for sending email
        function setFormAction(id) {
            const form = document.getElementById('sendForm');
            form.action = `/courriers/${id}/send-email`;
        }

        // Auto-submit filter form when filter values change
        const filterForm = document.getElementById('filterForm');
        if (filterForm) {
            filterForm.querySelectorAll('select, input').forEach((input) => {
                input.addEventListener('change', () => filterForm.submit());
            });
        }

        // Fetch results and update table via AJAX
        function fetchResults(page = 1) {
            let formData = $('#filter-form').serialize() + `&page=${page}`;
            $.ajax({
                url: $('#filter-form').attr('action'),
                method: 'GET',
                data: formData,
                beforeSend: () => $('#loading-spinner').show(),
                success: (response) => {
                    $('tbody').html($(response).find('tbody').html());
                },
                error: (xhr, status, error) => console.error("AJAX Error: ", status, error),
                complete: () => $('#loading-spinner').hide(),
            });
        }

        // Initialize AJAX results fetching on filter change
        $('#filter-form input, #filter-form select').on('change keyup', () => fetchResults());
        $(document).on('click', '.pagination a', function (event) {
            event.preventDefault();
            fetchResults($(this).attr('href').split('page=')[1]);
        });

        // Dynamic user fetching based on selected service
        const serviceSelect = document.getElementById('service_id');
        const userSelect = document.getElementById('user_ids');
        if (serviceSelect && userSelect) {
            serviceSelect.addEventListener('change', function () {
                const serviceId = this.value;
                userSelect.innerHTML = ''; // Clear previous options

                if (serviceId) {
                    fetch(`/services/${serviceId}/users`)
                        .then(response => response.json())
                        .then(data => {
                            data.employees.forEach(employee => {
                                const option = document.createElement('option');
                                option.value = employee.id;
                                option.textContent = employee.email;
                                userSelect.appendChild(option);
                            });
                        })
                        .catch(error => console.error('Error fetching users:', error));
                }
            });
        }
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const serviceDropdown = document.getElementById('service_id');
    const userDropdown = document.getElementById('user_ids');

    // Listen for changes on the service dropdown
    serviceDropdown.addEventListener('change', function () {
        const serviceId = this.value;

        // Clear the user dropdown
        userDropdown.innerHTML = '';

        if (serviceId) {
            // Make an AJAX request to get the employees for the selected service
            fetch(`/services/${serviceId}/employees`)
                .then(response => response.json())
                .then(employees => {
                    if (employees.length > 0) {
                        employees.forEach(employee => {
                            const option = document.createElement('option');
                            option.value = employee.id;
                            option.textContent = `${employee.name} (${employee.email})`;
                            userDropdown.appendChild(option);
                        });
                    } else {
                        const option = document.createElement('option');
                        option.textContent = 'No employees found';
                        userDropdown.appendChild(option);
                    }
                })
                .catch(error => {
                    console.error('Error fetching employees:', error);
                    const option = document.createElement('option');
                    option.textContent = 'Error fetching employees';
                    userDropdown.appendChild(option);
                });
        } else {
            const option = document.createElement('option');
            option.textContent = 'Please select a service first';
            userDropdown.appendChild(option);
        }
    });
});


</script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>

@endsection