<?php
    if(have_rows("social_menu", "option")):
        echo '<ul class="social-media__list">';
        while (have_rows("social_menu", "option")): the_row();
            echo '<li class="social-media__item">';
                echo '<a href="' . get_sub_field("account_link", "option") . '">' . get_image_html_code_by_id(get_sub_field("icon", "option")) . '</a>';
            echo '</li>';
        endwhile;
        echo '</ul>';
    endif;