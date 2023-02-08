@if ($categories->count())
    <div class="container">

        <div class="row">
           
            @foreach ($categories as $category)
                <div class="col-lg-4 col-md-4 col-sm-6 mix mt-4">
                    <x-category-card :category="$category" />
                </div>
            @endforeach
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mt-5">
            <div class="float-right">
                {{ $categories->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
@else
    <h5>Unfortunately, there are currently no categories available for you. Please check back at a later time.</h5>
@endif
