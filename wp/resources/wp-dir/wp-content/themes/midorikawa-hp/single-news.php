<?php
if (!defined('ABSPATH')) exit;
get_header();
?>
<main class="ly_main">
    <div class="bl_secondPageHead">
        <?php require(get_theme_file_path('/inc/components/breadcrumbs.php')); ?>
        <div class="ly_container">
            <?php if (have_posts()) : the_post(); ?>
                <div class="bl_newsInfo">
                    <span class="bl_newsInfo_date"><?php echo esc_html(get_the_date('Y.m.d')) ?></span>
                    <?php
                    $terms = get_the_terms(get_the_ID(), 'news-category');
                    if ($terms && !is_wp_error($terms)) {
                        foreach ($terms as $term) {
                            echo '<span class="bl_newsInfo_category">' . $term->name . '</span>';
                        }
                    };
                    ?>
                </div>
                <h1 class="news_title">
                    <?php echo esc_html(get_the_title()); ?>
                </h1>
            <?php endif; ?>
        </div>
    </div>
    <!-- /.bl_secondPageHead -->

    <div class="ly_section __ptSmall">
        <div class="ly_container __mx785">
            <div class="news_contents">
                <p>
                    <?php echo nl2br(esc_html(get_field('news_detail'))); ?>
                </p>
            </div>
            <div class="news_link">
                <?php
                // 前の記事
                $prev_post = get_previous_post();
                if ($prev_post) :
                    $prev_title = get_the_title($prev_post->ID);
                    $prev_url = get_permalink($prev_post->ID);
                ?>
                    <a href="<?php echo esc_url($prev_url); ?>" class="news_link_nav __prev"><span class="hp_noneSp">前の記事へ</span></a>
                <?php endif; ?>
                <a href="<?php echo get_url(Post::NEWS); ?>" class="news_link_btn">一覧を見る</a>
                <?php
                // 次の記事
                $next_post = get_next_post();
                if ($next_post) :
                    $next_title = get_the_title($next_post->ID);
                    $next_url = get_permalink($next_post->ID);
                ?>
                    <a href="<?php echo esc_url($next_url); ?>" class="news_link_nav __next"><span class="hp_noneSp">次の記事へ</span></a>
                <?php endif; ?>
            </div>
        </div>
        <!-- /.ly_container -->
    </div>
    <!-- /.ly_section -->
</main>
<!-- /.ly_main -->
<?php get_footer(); ?>