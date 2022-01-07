@extends('landing-page')

@section('title', '| Homepage')

@section('content')  

<!-- Page Content -->
<body>

    <div class="container">
        <div class="row">	    
            <div class="col-md-6 col-md-8 mx-auto">

            <!-- Show Success message when we add new book successfuly -->
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif  

            <!-- Show errors when we add a new post -->
            @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

                  
            <h1>Add New Book</h1>
            <br>

            <form action="{{route('book.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">Book Title *</label>
                    <input type="text" class="form-control" name="name" required data-validation-required-message="Please enter book name">
                </div>

                <div class="form-group">
                    <label for="author">Author *</label>
                    <input type="text" class="form-control" name="author" required>
                </div>

                <div class="form-group">
                    <label for="publisher">Publisher</label>
                    <input type="text" class="form-control" name="publisher">
                </div>

                <div class="form-group">
                    <label for="pages">Pages Number</label>
                    <input type="number" class="form-control" name="pages" >
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea rows="10" class="form-control" name="description"></textarea>
                </div>

                <div class="form-group">
                    <label for="image">Book Cover</label>
                    <div class="custom-file">
                        <input type="file"  class="form-control" name="image" accept="image/*" />                        
                    </div>                    
                </div>

                <div class="form-group">
                    <label for="category">Category</label>
                    <select class="form-control" name="category">
                        <option value="0"> </option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id}}"> {{ $category->name}}</option>
                        @endforeach                                            
                    </select>		
                </div>

                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="text" class="form-control" name="price" placeholder="$00.00">
                </div>

                <div class="form-group">
                    <p>* - required fields</p>
                </div>

                <br>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        Create
                    </button>
                    <a href="#" name="cancel" class="btn btn-default" >
                        Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

</body>

@endsection