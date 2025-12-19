<?php
/**
 * フッターコンポーネント
 *
 * このファイルでは、サイト全体で使用するフッターを定義します。
 * コピーライト、会社情報などを含みます。
 */
?>

<footer class="ly_footer">
    <div class="ly_container">
        <div class="ly_footer_inner">
            <div class="ly_footer_info">
                <p class="ly_footer_copyright">&copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars(COMPANY_NAME, ENT_QUOTES, 'UTF-8'); ?>. All rights reserved.</p>
                <address class="ly_footer_address">
                    <p class="ly_footer_addressText"><?php echo htmlspecialchars(COMPANY_ADDRESS, ENT_QUOTES, 'UTF-8'); ?></p>
                    <p class="ly_footer_addressTel">TEL: <a href="tel:<?php echo str_replace(['-', ' '], '', COMPANY_TEL); ?>" class="ly_footer_addressLink"><?php echo htmlspecialchars(COMPANY_TEL, ENT_QUOTES, 'UTF-8'); ?></a></p>
                </address>
            </div>
        </div>
    </div>
</footer>

