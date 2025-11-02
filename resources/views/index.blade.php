<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WriteDiary</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
    .body {
        background-color:#f6f6f6;
        background-image: repeating-linear-gradient(45deg,
                rgba(255, 255, 255, 0.2) 0px,
                rgba(255, 255, 255, 0.2) 2px,
                transparent 2px,
                transparent 6px);
        font-family: 'Poppins', sans-serif;
        width: 100%;
        margin: 0;
        padding: 0;
    }

    /* Navbar */
    .navbar {
        background-color: #830a71ff;
        color: #fff;
        max-width: 100%;
        overflow-x: hidden;
    }

    .navbar-brand {
        color: #fff !important;
        font-weight: bold;
        font-size: 1.2rem;
    }

    .navbar input {
        border-radius: 20px;
        border: none;
        font-size: 0.9rem;
    }

    /* Diary list cards */
    .diary-card {
        background-color: #fff;
        border-left: 6px solid #d63384;
        border-radius: 10px;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
        padding: 15px;
        margin-bottom: 15px;
        max-width: 95%;
        overflow-x: hidden;
    }

    .date-box {
        width: 60px;
        height: 60px;
        border-radius: 10px;
        background-color: #f8f9fa;
        text-align: center;
        margin-right: 15px;
        font-weight: 600;
        font-size: 0.9rem;
        color: #333;
    }

    .date-box div:first-child {
        color: #d63384;
        font-size: 0.8rem;
    }

    .diary-card h6 {
        font-weight: 600;
        margin-bottom: 4px;
        color: #333;
    }

    .diary-card p {
        margin: 0;
        color: #555;
        font-size: 0.9rem;
    }

    /* Floating Add Button */
    .fab {
        position: fixed;
        bottom: 55px;
        right: 30px;
        width: 85px;
        height: 85px;
        border-radius: 50%;
        background-color: #e88206ff;
        color: white;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 22px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        cursor: pointer;
        max-width: 100vw;
        transition: 0.3s;
    }

    .fab:hover {
        background-color: #b12a6c;
    }
    </style>
</head>

<body class='body border border-0 rounded-lg fixed min-h-screen max-w-screen'>

    <!-- Navbar -->
    <nav class="navbar navbar-dark px-2">
        <a class="navbar-brand" href="#"><i class="fa-solid fa-book-open"></i> WriteDiary</a>
        <!-- <form class="d-flex ms-auto">
      <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-light" type="submit"><i class="fa fa-search"></i></button>
    </form> -->
    </nav>

    <!-- Diary Entries -->
    <div class="container mt-4">
        @foreach($products as $p)
        <a class='diary-card d-flex w-full justify-content-between' style="text-decoration: none" href='/show/{{$p->id}}'>
            <div class=" d-flex align-items-center ">
                <div class="date-box" style="width:90px">
                    <div>{{ \Carbon\Carbon::parse($p->date)->format('d') }}</div>
                    <div>
                        <td>{{ \Carbon\Carbon::parse($p->date)->format('F') }}</td>
                    </div>
                    <div class='text-secondary'>'{{ \Carbon\Carbon::parse($p->date)->format('y') }}</div>
                </div>
                <div class='px-2'>
                    <h6>{{$p->title}}</h6>
                    <p>{{ strlen($p->notes) > 100 ? substr($p->notes, 0, 100) . '...' : $p->notes }}</p>

                </div>
            </div>
            <div  class='d-flex justify-content-end w-full'>
                <form action='/delete/{{$p->id}}' class='align-items-center' method="POST"
                    style="display:inline;background-color:#fff;justify-content:end" class="position-absolute"
                    style="top:10px; right:10px;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-transparent btn-lg align-items-center"
                        style="border-radius:50%; margin-right:5px;">
                        <i class="fa-solid fa-trash-can" style="color:orange"></i>
                    </button>
                </form>
            </div>
        </a>
        @endforeach
    </div>

    <!-- Floating Add Button -->
    <div class="fab">
        <i class="fa-solid fa-pen"></i>
    </div>
    <button class="fab btn btn-light btn-lg " style="border-radius:50%;"><i class="fa-solid fa-plus fa-2x"
            onclick="window.location.href='{{ route('products.create') }}'"></i></button>
</body>

</html>