<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Write Note</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
/>

</head>

<form action='/store' method='POST' class='min-h-screen'
    style="margin:0; padding:0; background-color:#f6f6f6; font-family:Poppins, sans-serif;  display:flex; align-items:center; justify-content:center;">
    @csrf
    <div class="container-fluid"
        style=" width:100%; background-color:#f0e0f7; border-radius:16px; box-shadow:0 0 10px rgba(0,0,0,0.1); padding:20px; min-height:100vh; display:flex; flex-direction:column; justify-content:space-between;">

        <!-- Header -->
        <div>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="/" class="btn btn-transparent btn-sm" style="border-radius:50%;font-size:1.5rem;font-weight:700"><i class="bi bi-chevron-left"></i>
</a>
                <h6 style="margin:0; font-weight:600;">Write your thoughts...</h6>
                <div>
                   
                    <button class="btn btn-transparent btn-sm" style="border-radius:50%;font-size:1.5rem"><i class="bi bi-share"></i></button>
                </div>
            </div>

            <!-- Date & Title Box -->
            <div style="background-color:#fff; border-radius:8px; padding:15px; margin-bottom:10px">
                <div class="flex flex-col align-items-center mb-2">
                    <input type="date" class="form-control border-0 p-0 font-bold" value="{{old('date')}}"
                        style="background:transparent; box-shadow:none;" name='date'>
                        @error('date')
                            <p class="text-danger pt-3 m-0">{{$message}}</p>
                        @enderror
                    <!-- <i class="bi bi-calendar me-2"></i> -->
                </div>
            </div>
            <div style="background-color:#fff; border-radius:8px; padding:15px; margin-bottom:10px">
                <div class="d-flex align-items-center ">
                    <i class="bi bi-pencil me-2"></i>
                    <div class='flex flex-col'>
                        <input type="text" class="form-control border-0 p-0"
                        style="background:transparent; box-shadow:none;" name='title' value="{{old('title')}}">
                        @error('title')
                            <p class='text-danger m-0 p-0'>{{$message}}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Note Text Box -->
            <div 
                style="background-color:#fff; border-radius:8px; padding:10px; margin-bottom:15px; height:60vh; overflow-y:auto;">
                <textarea rows="10" name='notes'  placeholder="Dear Diary, 📝" min={200}
                    style="width:100%; height:100%; border:none; outline:none; resize:none; background:transparent;text-indent:50px; padding-top:10px;"></textarea>
                    @error('notes')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
            </div>
        </div>

        <!-- Save Button -->
        <button class="btn w-100" type='submit'
            style="background-color:#c2188b; color:white; font-weight:600; border:none; border-radius:8px; padding:12px;">
            Save
        </button>
        
    </div>

</form>

</html>