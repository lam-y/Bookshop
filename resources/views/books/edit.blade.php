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

                  
            <h1>Edit Book</h1>
            <br>

            <form action="{{route('book.update', $book->id)}}" method="POST" enctype="multipart/form-data">
                @csrf  	
                @method('PUT')
                
                <div class="form-group">
                    <label for="name">Book Title *</label>
                <input type="text" class="form-control" name="name" value="{{ $book->name }}" required>
                </div>

                <div class="form-group">
                    <label for="author">Author *</label>
                    <input type="text" class="form-control" name="author" value="{{ $book->author }}" required>
                </div>

                <div class="form-group">
                    <label for="publisher">Publisher</label>
                    <input type="text" class="form-control" name="publisher" value="{{ $book->publisher }}">
                </div>

                <div class="form-group">
                    <label for="pages">Pages Number</label>
                    <input type="number" class="form-control" name="pages" value="{{ $book->pages }}">
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea rows="10" class="form-control" name="description">{{ $book->description }}</textarea>
                </div>

                <div class="form-group">
                    <label for="category">Category</label>
                    <select class="form-control" name="category" selected="{{ $book->category_id }}">
                        <option value="0"> </option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ ($category->id == $book->category_id) ? 'selected' : '' }}> {{ $category->name }}</option>
                        @endforeach	
                      </select>				
                </div>

                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="text" class="form-control" name="price" value="{{ $book->price }}">
                </div>

                <div class="form-group">
                    <label for="image">Book Cover</label>
                    <div class="row" style="margin-top: 5px; margin-bottom: 5px">                                                                                
                        <div class="custom-file col">
                            <input type="file"  class="form-control" name="image" accept="image/*" />                        
                        </div>  
                        <div class="col-3" style="align-content: center">
                            <img src="{{asset('images/'.$book->image)}}" width="150" height="200" alt="" />
                            <p style="text-align: center; margin-bottom:1px"> Current Cover</p>
                        </div>  
                    </div>                
                </div>

                <div class="form-group">
                    <p>* - required fields</p>
                </div>

                <br>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        Save Changes
                    </button>
                    <a href="{{ route('book.show', $book->id) }}" name="cancel" class="btn btn-default" >
                        Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

</body>

@endsection