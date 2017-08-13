
<?php get_header(); ?>
<?php get_template_part('template-parts/breadcrumbs'); ?>

<section class="post_blog_bg primary-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="col-md-8">

                    <!--цикл вывода постов-->
                    <?php if (have_posts()) : ?><!--если есть пості в БД-->
                    <?php while (have_posts()) : the_post();

                        get_template_part('template-parts/content', 'page');
//вывод комментариев
                        if (comments_open() || get_comments_number()) {
                            comments_template();
                        }


                    endwhile; ?>
                    <?php endif; ?>

                    <?php wptoots_pagination(); ?>


                </div>

                <!--sidebar here -->
                <?php get_sidebar(); ?>

            </div>
        </div>
    </div>
</section>
<?php get_footer();