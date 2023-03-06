<script src="{{ asset('assets/js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.nice-select.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.slicknav.js') }}"></script>
<script src="{{ asset('assets/js/mixitup.min.js') }}"></script>
<script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>
<script src="{{ asset('assets/js/toaster.js') }}"></script>
<script>
    $(document).ready(function() {
        $(document).on('keyup', '#global_search_bar', function() {
            if ($(this).val()) {
                $.ajax({
                    url: "{{ route('search') }}",
                    type: "GET",
                    data: {
                        search_query: $(this).val()
                    },
                    success: function(response) {
                        if (response.success) {
                            $("#search_result").empty();
                            if (response.results.length > 0) {
                                for (const key in response.results) {
                                    if (response.results.hasOwnProperty.call(response
                                            .results,
                                            key)) {
                                        const result = response.results[key];
                                        $("#search_result").append(
                                            `<li class="list-group-item"><div class="d-flex"><img src="${result.thumb}" style="width:50px" class="rounded px-2"><a class="pt-3" href="${result.url}">${result.name}</a></div></li>`
                                        );
                                    }
                                }
                            } else {
                                `<li class="list-group-item"><strong>Nothing found.</strong></li>`
                            }
                        }

                    },
                    error: function(response) {
                        console.error("error");
                    }
                });
            }
            $('search_result');
        });
        $(document).click(function(e) {
            let shouldClose = !($(event.target).parents('.hero__search').length);
            if (shouldClose) {
                $('#search_result').empty();
            }
        });
        var selector;
        $(document).on('submit', 'form', function(e) {
            if ($(this).data('ajax')) {
                e.preventDefault();
                var selector = $(this).find('button[type="submit"]');
                selector.attr('disabled', true);
                let url = $(this).prop('action');
                let method = $(this).prop('method') ?? 'GET';
                let _token = "{{ csrf_token() }}"
                var formData = new FormData($(this)[0]);
                formData.append('_token', _token);
                $(this).find('.quill-input').each(function() {
                    let name = $(this).data('name');
                    let description = $(this).find('.ql-editor').html();
                    formData.append(name, description);
                });
                $.ajax({
                    url: url,
                    data: formData,
                    type: method,
                    processData: false,
                    cache: false,
                    contentType: false,
                    success: function(response) {
                        console.log(response);

                        if (response.success) {

                            toastr.success(
                                response.message,
                                "Success", {
                                    timeOut: 5000,
                                    extendedTimeOut: 0,
                                    closeButton: true,
                                    closeDuration: 0
                                }
                            );
                        } else if (response.error) {

                            toastr.error(
                                response.message,
                                "Error", {
                                    timeOut: 5000,
                                    extendedTimeOut: 0,
                                    closeButton: true,
                                    closeDuration: 0
                                }
                            );
                        } else if (response.warning) {
                            toastr.warning(
                                response.message,
                                "warning", {
                                    timeOut: 5000,
                                    extendedTimeOut: 0,
                                    closeButton: true,
                                    closeDuration: 0
                                }
                            );
                        }
                        if (response.reload) {
                            window.location.reload();
                        }
                        if (response.redirect) {
                            window.location.href = response.url;
                        }
                        if (response.table_reload) {
                            const tableReload = new Event("table_reload");
                            document.dispatchEvent(tableReload)
                        }
                        if (response.event) {
                            const event = new Event(response.event.name);
                            document.dispatchEvent(event)
                        }
                    },
                    error: function(response) {
                        console.log(response);
                        if (response.status == 422) {
                            const errors = response.responseJSON.errors;
                            for (const key in errors) {
                                $(`[name="${key}"]`).addClass('border-danger');
                                if (errors.hasOwnProperty.call(errors, key)) {
                                    const error = errors[key];
                                    toastr.error(
                                        error[0],
                                        key.toUpperCase(), {
                                            timeOut: 5000,
                                            extendedTimeOut: 0,
                                            closeButton: true,
                                            closeDuration: 0
                                        }
                                    );
                                }
                            }
                        } else {
                            toastr.error(
                                response.message,
                                "Error", {
                                    timeOut: 5000,
                                    extendedTimeOut: 0,
                                    closeButton: true,
                                    closeDuration: 0
                                }
                            );
                        }

                    },
                    complete: function() {
                        selector.removeAttr('disabled');
                    }
                });
            }
        });

    });


    var currentProduct = null;
    $(document).on('click', '.select-product', function() {
        currentProduct = $(this);
    });




    @if (auth()->check())
        updateCartAndWishlist();

        function updateCartAndWishlist() {
            $.ajax({
                url: "{{ route('cart.wishlist.counts') }}",
                type: "GET",
                success: function(response) {
                    console.log(response);
                    $('.wishlist-count').text(response.wishlistItems)
                    $('.cart-count').text(response.cartItems)
                }
            });
        }

        document.addEventListener("product_added_to_wishlist", function() {
            updateCartAndWishlist();
            currentProduct.addClass('bg-primary text-white');
        });
        document.addEventListener("product_removed_from_wishlist", function() {
            updateCartAndWishlist();
            currentProduct.removeClass('bg-primary text-white');
        });
        document.addEventListener("product_added_to_cart", function() {
            updateCartAndWishlist();
            currentProduct.addClass('bg-primary text-white');
        });
        document.addEventListener("product_removed_from_cart", function() {
            updateCartAndWishlist();
            currentProduct.removeClass('bg-primary text-white');
        });
    @endif
</script>
