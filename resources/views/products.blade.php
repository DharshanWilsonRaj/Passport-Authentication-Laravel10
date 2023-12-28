<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
     {{url()->previous()}}
    {{-- for displaying product successfully stored --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex align-items-center justify-content-center flex-column">
        <h5>Products</h5>
        <form method="post" action="{{ route('productStore') }}" enctype="multipart/form-data"
            class="d-flex flex-column gap-2">
            @csrf
            <label for="name">Product Name:</label>
            <input type="text" name="name" required>

            <label for="price">Product Price:</label>
            <input type="number" name="price" required>

            <label for="image">Product Image:</label>
            <input type="file" name="image" accept="image/*" required>

            <button type="submit">Submit</button>
        </form>
    </div>

    <div class="container my-2">
        <div class="border p-2 row gap-2">
            @foreach ($products as $product)
                <div class="product card col-2 ">
                    <h2 class=""> {{ $product->name }}</h2>
                    <p class="fs-4">Price: ${{ $product->price }}</p>
                    @if ($product->image)
                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}"
                            style="height: 150px; ">
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
