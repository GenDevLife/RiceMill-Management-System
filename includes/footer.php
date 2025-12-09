    </main>
    
    <!-- Real-time Clock -->
    <p class="time" id="real-time"></p>
    
    <!-- Main JavaScript -->
    <script src="<?php echo $basePath ?? ''; ?>assets/js/script.js"></script>
    
    <?php if (isset($additionalJs)): ?>
        <?php foreach ($additionalJs as $js): ?>
            <script src="<?php echo $basePath ?? ''; ?>assets/js/<?php echo $js; ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>
