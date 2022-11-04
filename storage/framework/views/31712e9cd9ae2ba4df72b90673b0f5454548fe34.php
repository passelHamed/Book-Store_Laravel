

<?php $__env->startSection('style'); ?>
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <?php if(session('flash_warning')): ?>
            <div class="col-md-8 text-center h4 p-2 bg-danger text-light rounded">
                This book has not been added, you have exceeded the number of books we have, the maximum number of books you can book from this book is <?php echo e(($book->number_of_copies - auth()->user()->booksInCart()->where('book_id',$book->id)->first()->pivot->number_of_copies)); ?> book
            </div>
        <?php endif; ?>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Show Book Details
                </div>
                <div class="card-body">
                    <table class="table">
                        <?php if(auth()->guard()->check()): ?>
                            <div class="form text-right mb-3">
                                <input id="bookId" type="hidden" value="<?php echo e($book->id); ?>">
                                <span class="text-muted mb-3"><input class="form-control d-inline mx-auto" id="quantity" name="quantity" type="number" value="1" min="1" max="<?php echo e($book->number_of_copies); ?>" style="width:10%;" required></span>
                                <button type="submit" class="add-cart btn bg-cart me-2"><i class="fa fa-cart-plus"></i> add to cart</button>
                            </div>
                        <?php endif; ?>
                        <tr>
                            <th>Title</th>
                            <td class="lead"><b><?php echo e($book->title); ?></b></td>
                        </tr>
                        <tr>
                            <th>Users Ratings</th>
                            <td>
                                <span class="score">
                                    <div class="score-wrap">
                                        <span class="stars-active" style="width:<?php echo e($book->rate()*20); ?>%;">
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                        </span>
                                        <span class="stars-inactive">
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                </span>
                                <span>Rating number <?php echo e($book->ratings()->count()); ?> user</span>
                            </td>
                        </tr>
                        <?php if($book->isbn): ?>
                            <tr>
                                <th>Serial Number</th>
                                <td><?php echo e($book->isbn); ?></td>
                            </tr>
                        <?php endif; ?>
                        <tr>
                            <th>Cover Photo</th>
                            <td><img class="img-fluid img-thumbnail" src="<?php echo e(asset('/storage/' . $book->cover_image)); ?>" width="400" height="150"></td>
                        </tr>
                        <?php if($book->category): ?>
                            <tr>
                                <th>Category</th>
                                <td><?php echo e($book->category->name); ?></td>
                            </tr>
                        <?php endif; ?>
                        <?php if($book->Authors()->count() > 0): ?>
                            <tr>
                                <th>Authors</th>
                                <td>
                                    <?php $__currentLoopData = $book->Authors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $author): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php echo e($loop->first ? '' : ','); ?>

                                        <?php echo e($author->name); ?>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                        <?php if($book->publisher): ?>
                            <tr>
                                <th>publisher</th>
                                <td><?php echo e($book->publisher->name); ?></td>
                            </tr>
                        <?php endif; ?>
                        <?php if($book->description): ?>
                            <tr>
                                <th>description</th>
                                <td><?php echo e($book->description); ?></td>
                            </tr>
                        <?php endif; ?>
                        <?php if($book->publish_year): ?>
                            <tr>
                                <th>publish year</th>
                                <td><?php echo e($book->publish_year); ?></td>
                            </tr>
                        <?php endif; ?>
                        <tr>
                            <th>number of pages</th>
                            <td><?php echo e($book->number_of_pages); ?></td>
                        </tr>
                        <tr>
                            <th>number of copies</th>
                            <td><?php echo e($book->number_of_copies); ?></td>
                        </tr>
                        <tr>
                            <th>price</th>
                            <td><?php echo e($book->price); ?> $</td>
                        </tr>
                    </table>
                    <?php if(auth()->guard()->check()): ?>
                        <h4 class="mb-3">Rate this book</h4>
                            <?php if(auth()->user()->rated($book)): ?>
                                <div class="rating">
                                    <span class="rating-star <?php echo e(auth()->user()->bookRating($book)->value == 5 ? 'checked' : ''); ?>" data-value="5"></span>
                                    <span class="rating-star <?php echo e(auth()->user()->bookRating($book)->value == 4 ? 'checked' : ''); ?>" data-value="4"></span>
                                    <span class="rating-star <?php echo e(auth()->user()->bookRating($book)->value == 3 ? 'checked' : ''); ?>" data-value="3"></span>
                                    <span class="rating-star <?php echo e(auth()->user()->bookRating($book)->value == 2 ? 'checked' : ''); ?>" data-value="2"></span>
                                    <span class="rating-star <?php echo e(auth()->user()->bookRating($book)->value == 1 ? 'checked' : ''); ?>" data-value="1"></span>
                                </div>
                            <?php else: ?>
                                <div class="rating">
                                    <span class="rating-star " data-value="5"></span>
                                    <span class="rating-star " data-value="4"></span>
                                    <span class="rating-star " data-value="3"></span>
                                    <span class="rating-star " data-value="2"></span>
                                    <span class="rating-star " data-value="1"></span>
                                </div>
                            <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script>
        $('.rating-star').click(function(){
            var submitStars = $(this).attr('data-value');
            $.ajax({
                type: 'post',
                url: <?php echo e($book->id); ?> + '/rate',
                data: {
                    '_token' : $('meta[name="csrf-token"]').attr('content'),
                    'value' : submitStars
                },
                success: function(){
                    location.reload();
                },
                error: function(){
                    toastr.error('Something wrong')
                }
            })
        })
    </script>

    <script>
        $('.add-cart').on('click',function(event){
            var token = '<?php echo e(Session::token()); ?>';
            var url = '<?php echo e(route('cart.add')); ?>';

            event.preventDefault();

            var bookId = $(this).parents(".form").find('#bookId').val()
            var quantity = $(this).parents(".form").find('#quantity').val()

            $.ajax({
                method: 'POST',
                url: url,
                data: {
                    quantity : quantity,
                    id : bookId,
                    _token : token
                },
                success : function(data){
                    $('span.badge').text(data.num_of_product);
                    toastr.success('The book has been added successfully')
                },
                error : function(){
                    toastr.error('something wrong');
                },
            })
        })
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\server\1-web devlopment\2-back_end\2-laravel\BookStore\resources\views/Project/detailsBook.blade.php ENDPATH**/ ?>