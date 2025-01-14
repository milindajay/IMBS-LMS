<footer class="bg-white shadow-lg mt-auto">
    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
        <div class="flex justify-center items-center">
            <div class="text text-sm text-gray-500 text-center">
                &copy; <?php echo date('Y'); ?> IMBS LMS - 177594 - Milinda John - DIT77
            </div>
        </div>
    </div>
</footer>
<?php if(isset($useJQuery) && $useJQuery): ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<?php endif; ?>
<?php if(isset($pageScript)): ?>
<script>
<?php echo $pageScript; ?>
</script>
<?php endif; ?>
</body>

</html>