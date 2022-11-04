

<?php $__env->startSection('style'); ?>
    <!-- Custom styles for this page -->
    <link href="<?php echo e(asset('theme/vendor/datatables/dataTables.bootstrap4.min.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('heading'); ?>
Show Users
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Users</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="books-table" class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>name</th>
                                <th>email</th>
                                <th>type user</th>
                                <th>options</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($user->name); ?></td>
                                    <td><?php echo e($user->email); ?></td>
                                    <td>
                                        <?php echo e($user->isSuperAdmin() ? 'Admin Public' : ($user->isAdmin() ? 'Admin' : 'User')); ?>

                                    </td>
                                    <td>
                                        <form class="mr-4 form-inline" action="/admin/users/<?php echo e($user->id); ?>" method="post" style="display: inline-block">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PATCH'); ?>
                                            <select class="form-control form-control-sm" name="administration_level">
                                                <option selected disabled>chosse type</option>
                                                <option value="0">User</option>
                                                <option value="1">Admin</option>
                                                <option value="2">Admin Public</option>
                                            </select>
                                            <button type="submit" class="btn btn-info btn-sm"><i class="fa fa-edit"></i>Edit</button>
                                        </form>
                                        <form action="/admin/users/<?php echo e($user->id); ?>" method="post" class="d-inline-block">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <?php if(auth()->user() != $user): ?>
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are You Sure?')"><i class="fa fa-trash"></i>Delete</button>
                                                <?php else: ?>
                                                    <button class="disabled btn btn-danger btn-sm"><i class="fa fa-trash"></i>Delete</button>
                                            <?php endif; ?>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <!-- Page level plugins -->
    <script src="<?php echo e(asset('theme/vendor/datatables/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('theme/vendor/datatables/dataTables.bootstrap4.min.js')); ?>"></script>
    <script>
        $(document).ready( function () {
            $('#books-table').DataTable();
        } );
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('theme.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\server\1-web devlopment\2-back_end\2-laravel\BookStore\resources\views/admin/indexUser.blade.php ENDPATH**/ ?>