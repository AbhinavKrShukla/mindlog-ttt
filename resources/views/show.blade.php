<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Write Note</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />

</head>

<form action="/update/{{$product->id}}" method="post"
    style="margin:0; padding:0; background-color:#f6f6f6; font-family:Poppins, sans-serif;  display:flex; align-items:center; justify-content:center;">
    @csrf
    @method('PUT')
    <div class="container-fluid"
        style=" width:100%; background-color:#f0e0f7; border-radius:16px; box-shadow:0 0 10px rgba(0,0,0,0.1); padding:20px; min-height:100vh; display:flex; flex-direction:column; justify-content:space-between;">

        <!-- Header -->
        <div>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <a href='/index' class="btn btn-light btn-lg" style="border-radius:50%"><i
                        class="bi bi-arrow-left"></i></a>
                <h6 style="margin:0; font-weight:600;">Refine your thoughts...</h6>
                <div>


                    <!-- <button class="btn btn-light btn-sm" style="border-radius:50%; margin-right:5px;">
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                       <i
                            class="bi bi-trash" type='submit'></i>
                        </form>
                    </button> -->
                    <button id="shareBtn" class="btn btn-light btn-lg" onclick="shareLink()" style="border-radius:50%;" type='button'>
                        <i class="bi bi-share"></i>
                    </button>

                </div>
            </div>

            <!-- Date & Title Box -->
            <div style="background-color:#fff; border-radius:8px; padding:15px; margin-bottom:10px">
                <div class="d-flex align-items-center mb-2 py-1">
                    <i class="bi bi-calendar me-2 "></i>
                    <div class='flex flex-col'>
                        <input type="date" class="form-control border-0 p-0 font-bold" readOnly
                            style="background:transparent; box-shadow:none;" name='date' value="{{$product->date}}">
                    </div>

                </div>
            </div>
            <div style="background-color:#fff; border-radius:8px; padding:15px; margin-bottom:10px">
                <div class="d-flex align-items-center py-1 ">
                    <i class="bi bi-pencil me-2"></i>
                    <div class='flex flex-col'>
                        <input type="text" class="form-control border-0 p-0" readOnly
                            style="background:transparent; box-shadow:none;" name='title' value="{{$product->title}}">

                    </div>
                </div>
            </div>

            <!-- Note Text Box -->
            <div
                style="background-color:#fafafa; border-radius:8px; padding:10px; margin-bottom:15px; height:80vh; overflow-y:auto;">
                <textarea rows="10" name='notes'
                    style="width:100%; height:100%; border:none; outline:none; resize:none; background:transparent;">
                    {{ $product->notes }}
        </textarea>
            </div>
        </div>

        <!-- Save Button -->

        <button class="fab btn btn-light btn-lg " type='submit'
            onclick="window.location.href='{{ route('products.create') }}'" style="border-radius:50%;
      position: fixed;
      bottom: 95px;
      right: 60px;
      width: 90px;
      height: 90px;
      border-radius: 50%;
      background-color: #e88206ff;
      color: white;
      display: flex;
      justify-content: center;
      align-items: center;
      font-size: 25px;
      
      cursor: pointer;
      max-width: 100vw;
      transition: 0.3s;">
            <i class="bi bi-check-lg" style="font-size:3.5rem;"></i>
        </button>

    </div>

</form>
<script>
function shareLink() {
    const button = document.getElementById('shareBtn');
    const icon = button.querySelector('i');

    const originalIconClass = icon.className;

    // Copy the current URL to clipboard
    navigator.clipboard.writeText(window.location.href).then(() => {
        // Change icon to tick mark
        icon.className = 'bi bi-check-circle-fill';

        // Revert back after 2 seconds
        setTimeout(() => {
            icon.className = originalIconClass;
        }, 2000);
    });
}
</script>

</html>