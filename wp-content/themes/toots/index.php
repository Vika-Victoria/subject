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

                            get_template_part('template-parts/content', get_post_format());

                         endwhile; ?>
                    <?php endif; ?>

                    <?php wptoots_pagination(); ?>

<!--                    <div class="next_page">-->
<!--                        <ul class="page-numbers">-->
<!--                            <li><span class="page-numbers current">1</span></li>-->
<!--                            <li><a href="#" class="page-numbers">2</a></li>-->
<!--                            <li><a href="#" class="page-numbers">3</a></li>-->
<!--                            <li><a href="#" class="page-numbers">4</a></li>-->
<!--                            <li><a href="#" class="next page-numbers">Next</a></li>-->
<!--                        </ul>-->
<!--                    </div>-->

                </div>

                <!--sidebar here -->
                <?php get_sidebar(); ?>

            </div>
        </div>
    </div>
</section>
<?php get_footer();