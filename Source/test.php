<?php

$tags = '<ol><li><em><strong><small>test5555</strong></em></li></ol>';
echo strip_tags(closetags($tags), '<ol><li><em><strong><small>');