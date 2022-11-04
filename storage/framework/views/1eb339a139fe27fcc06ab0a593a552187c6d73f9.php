
<?php $__env->startSection('style'); ?>
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Authors books</div>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <form action="/authors/search" method="get">
                                <?php echo csrf_field(); ?>
                                    <div class="row d-flex justify-content-center">
                                        <input type="text" name="search" id="search" class="col-3 mx-sm-3 mb-2 me-2" placeholder="search for Author . . .">
                                        <button type="submit" class="col-2 btn btn-secondary bg-secondary mb-2">Search</button>
                                    </div>
                                </form>
                        </div>
                        <hr>
                        <br>
                        <h3 class="mb-4 h4"><?php echo e($title); ?></h3>

                        <?php if($authors->count()): ?>
                            <ul class="list-group">
                                <?php $__currentLoopData = $authors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $author): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a href="/authors/<?php echo e($author->id); ?>">
                                        <li class="list-group-item">
                                            <?php echo e($author->name); ?> (<?php echo e($author->books->count()); ?>)
                                        </li>
                                    </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        <?php else: ?>
                            <div class="col-12 alert alert-info mt-4 mx-auto text-center">
                                not result
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\server\1-web devlopment\2-back_end\2-laravel\BookStore\resources\views/project/authors.blade.php ENDPATH**/ ?>