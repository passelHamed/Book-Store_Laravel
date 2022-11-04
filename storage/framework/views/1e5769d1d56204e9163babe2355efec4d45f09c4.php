

<?php $__env->startSection('style'); ?>
    <style>
        .card .card-body .card-title{
            height: 40px;
            overflow: hidden;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row">
            <form action="/search" method="get">
            <?php echo csrf_field(); ?>
                <div class="row d-flex justify-content-center">
                    <input type="text" name="search" id="search" class="col-3 mx-sm-3 mb-2" placeholder="search for book . . .">
                    <button type="submit" class="col-1 btn btn-secondary bg-secondary mb-2">Search</button>
                </div>
            </form>
        </div>
        <hr>
        <h3 class="my-2"><?php echo e($title); ?></h3>
        <div class="mt-50 mb-50">
            <div class="row">
                <?php if($books->count()): ?>
                    <?php $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>  
                        <?php if($book->number_of_copies > 0): ?>
                            <div class="col-lg-3 col-sm-6 col-md-4 mt-2">
                                <div class="card mb-3">
                                    <div>
                                        <div class="card-img-actions">
                                            <a href="/book/<?php echo e($book->id); ?>">
                                                <img src="<?php echo e(asset('storage/'. $book->cover_image)); ?>" class="card-img img-fluid" width="96" height="350" alt="">
                                            </a> 
                                        </div>
                                    </div>
                                    <div class="card-body bg-light text-center">
                                        <div class="mb-2">
                                            <h6 class="font-weight-semibold mb-2 card-title">
                                                <a href="/book/<?php echo e($book->id); ?>" class="text-default" data-abc="true"><?php echo e($book->title); ?></a>
                                            </h6>
                                            <a href="/categories/<?php echo e($book->category->id); ?>" class="text-muted" data-abc="true">
                                                <?php if($book->category != NULL): ?>
                                                    <?php echo e($book->category->name); ?>

                                                <?php endif; ?>
                                            </a>
                                        </div>
                                        <h3 class="mb-0 font-weight-semibold"><?php echo e($book->price); ?> $</h3>
                                        <div>
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
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <div class="alert alert-info" role="alert">
                        not result
                    </div>
                <?php endif; ?>
            </div>
            <?php echo e($books->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\server\1-web devlopment\2-back_end\2-laravel\BookStore\resources\views/project/gallery.blade.php ENDPATH**/ ?>