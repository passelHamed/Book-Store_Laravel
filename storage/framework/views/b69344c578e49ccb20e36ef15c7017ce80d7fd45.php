<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <p>Hello,<?php echo e($user->name); ?></p>
    <p>We have successfully received your request</p>
    <br>

    <table style="width:600px;">
        <thead>
            <tr>
                <th>Title Book</th>
                <th>Price</th>
                <th>Number of copies</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $subTotal = 0
            ?>
            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($order->title); ?></td>
                    <td><?php echo e($order->price); ?> $</td>
                    <td><?php echo e($order->pivot->number_of_copies); ?></td>
                    <td><?php echo e($order->pivot->number_of_copies * $order->price); ?> $</td>

                    <?php
                        $subTotal += $order->pivot->number_of_copies * $order->price
                    ?>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <hr>
            <tr>
                <td colspan="3" style="border-top:1px solid #ccc;"></td>
                <td style="font-size:15px;font-weight:bold;border-top:1px solid #ccc;">Total Price : <?php echo e($subTotal); ?> $</td>
            </tr>
        </tbody>
    </table>
</body>
</html><?php /**PATH C:\laragon\www\server\1-web devlopment\2-back_end\2-laravel\BookStore\resources\views/mails/Order-Mail.blade.php ENDPATH**/ ?>