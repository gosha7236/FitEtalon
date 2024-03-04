<div class="welcome-getting-started">
    <div class="welcome-demo-import">
        <h3><?php echo esc_html__('Manual Setup', 'fitness-fse'); ?></h3>

        <p><?php echo esc_html__('If you want to change default homage page with your own created page, Go to settings > reading and set your page.', 'fitness-fse'); ?></p>
        
        <p><strong><?php echo esc_html__('FROM ELEMENTOR', 'fitness-fse'); ?></strong></p>
        <ol>
            <li><?php echo esc_html__('Firstly install and activate "Elementor Website Builder" plugin from', 'fitness-fse'); ?> <a href="<?php echo esc_url(admin_url('post-new.php?page=fitness-fse-welcome&section=recommended_plugins')); ?>" target="_blank"><?php echo esc_html__('Recommended Plugin page.', 'fitness-fse'); ?></a></li>
            <li><?php echo esc_html__('Create a new page and edit with Elementor. Drag and drop the elements in the Elementor to create your own design.', 'fitness-fse'); ?></li>
            <li><?php echo esc_html__('Now go to Appearance &gt; Customize &gt; Homepage Settings and choose "A static page" for "Your latest posts" and select the created page for "Home Page" option.', 'fitness-fse'); ?></li>
        </ol>
        
    </div>

    <div class="welcome-demo-import">
        <h3><?php echo esc_html__('Demo Importer', 'fitness-fse'); ?></h3>
        <div class="welcome-theme-thumb">
            <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/screenshot.png'); ?>" alt="<?php printf(esc_attr__('%s Demo', 'fitness-fse'), $this->theme_name); ?>">
        </div>

        <div class="welcome-demo-import-text">
            <p><?php esc_html_e('Or you can get started by importing the demo with just one click.', 'fitness-fse'); ?></p>
            <p><?php echo esc_html__('Click on the button below to install and activate the One Click Demo Importer Plugin.', 'fitness-fse'); ?></p>
            <?php echo $this->generate_demo_installer_button(); ?>
        </div>
    </div>
</div>