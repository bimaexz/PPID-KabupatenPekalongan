<?php
/**
* @package   Gridbox
* @author    Balbooa http://www.balbooa.com/
* @copyright Copyright @ Balbooa
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

defined('_JEXEC') or die;
$currency = self::$store->currency;
ob_start();
?>
<div class="ba-add-to-cart-variations">
<?php
foreach ($variations as $variation) {
?>
    <div class="ba-add-to-cart-variation" data-type="<?php echo $variation->type; ?>">
        <div class="ba-add-to-cart-row-label"><?php echo $variation->title; ?></div>
        <div class="ba-add-to-cart-row-value" data-type="<?php echo $variation->type; ?>">
<?php
            if ($variation->type == 'dropdown') {
                $li = '';
                $textValue = JText::_('SELECT');
                $value = '';
            }
            foreach ($variation->items as $item) {
                $flag = in_array($item->option_key, $active);
                if ($variation->type == 'dropdown') {
                    if ($flag) {
                        $textValue = $item->value;
                        $value = $item->option_key;
                    }
                    $li .= '<li data-value="'.$item->option_key.'" class="'.($flag ? 'selected' : '')
                        .'">'.$item->value.'</li>';
                } else if ($variation->type == 'tag') {
?>
                    <span data-value="<?php echo $item->option_key; ?>" class="<?php echo $flag ? 'active' : ''; ?>">
                        <?php echo $item->value; ?>
                    </span>
<?php
                } else if ($variation->type == 'color') {
?>
                    <span data-value="<?php echo $item->option_key; ?>" class="<?php echo $flag ? 'active' : ''; ?>">
                        <span style="--variation-color-value: <?php echo $item->color; ?>;"></span>
                        <span class="ba-tooltip ba-top"><?php echo $item->value; ?></span>
                    </span>
<?php
                }  else if ($variation->type == 'image') {
                    $images = json_decode($item->images);
                    if (!empty($images)) {
                        $item->image = $images[0];
                    }
                    $image = !gridboxHelper::isExternal($item->image) ? JUri::root().$item->image : $item->image;
?>
                    <span data-value="<?php echo $item->option_key; ?>" class="<?php echo $flag ? 'active' : ''; ?>">
                        <span style="--variation-image-value: url(<?php echo $image; ?>);"></span>
                        <span class="ba-tooltip ba-top"><?php echo $item->value; ?></span>
                    </span>
<?php
                } else if ($variation->type == 'radio') {
?>
                    <div class="ba-checkbox-wrapper">
                        <span><?php echo $item->value; ?></span>
                        <label class="ba-radio">
                            <input type="radio" name="variation-<?php echo $item->field_id; ?>"
                                class="<?php echo $flag ? 'active' : ''; ?>"
                                value="<?php echo $item->option_key; ?>"<?php echo $flag ? ' checked' : ''; ?>>
                            <span></span>
                        </label>
                    </div>
<?php
                }
            }
            if ($variation->type == 'dropdown') {
?>
                <div class="ba-custom-select">
                <input readonly="" onfocus="this.blur()" type="text" value="<?php echo $textValue; ?>">
                <input type="hidden" value="<?php echo $value; ?>">
                <i class="ba-icons ba-icon-caret-down"></i>
                <ul><?php echo $li; ?></ul>
            </div>
<?php
            }
?>
        </div>
    </div>
<?php
}
?>
</div>
<div class="ba-add-to-cart-extra-options">
<?php
$fileQty = 0;
$hasFileQty = false;
foreach ($options as $option_id => $option) {
    $isFile = $option->type == 'file';
    if ($isFile && $option->file_options->quantity && ($option->required || !empty($option->attachments))) {
        $hasFileQty = true;
        $fileQty += count($option->attachments);
    }
?>
<div class="ba-add-to-cart-extra-option" data-ind="<?php echo $option_id; ?>" data-required="<?php echo $option->required; ?>"
    data-type="<?php echo $option->type; ?>"<?php echo $isFile ? ('data-droppable="'.($option->file_options->droppable ? 1 : 0).'"') : ''; ?> >
    <div class="ba-add-to-cart-row-label"><?php echo $option->title; ?></div>
    <div class="ba-add-to-cart-row-value" data-type="<?php echo $option->type; ?>">
<?php
        if ($option->type == 'dropdown') {
            $li = '';
            $textValue = JText::_('SELECT');
            $value = '';
        } else if ($option->type == 'textinput') {
?>
        <input type="text" value="">
<?php
        } else if ($option->type == 'textarea') {
?>
        <textarea value=""></textarea>
<?php
        } else if ($isFile) {
            $sizeText = JText::_('MAXIMUM_FILE_SIZE').' '.($option->file_options->size / 1000).'mb';
?>
        <div class="ba-add-to-cart-upload-file">
            <div class="ba-add-to-cart-attach-file" data-droppable="<?php echo $option->file_options->droppable ? 1 : 0; ?>">
                <span class="ba-add-to-cart-drag-drop-attach-file-title"><?php echo JText::_('DRAG_DROP_FILES_HERE'); ?></span>
                <span class="ba-add-to-cart-drag-drop-attach-file-text"><?php echo JText::_('OR'); ?></span>
                <span class="ba-add-to-cart-drag-drop-attach-file-btn"><?php echo JText::_('BROWSE'); ?></span>
                <span class="ba-add-to-cart-drag-drop-attach-file-size"><?php echo $sizeText; ?></span>
                <input type="file"<?php echo $option->file_options->multiple ? ' multiple' : ''; ?> data-size="<?php echo $option->file_options->size; ?>"
                    data-types="<?php echo $option->file_options->types; ?>"
                    data-count="<?php echo $option->file_options->multiple ? $option->file_options->count : 1; ?>">
            </div>
            <div class="ba-add-to-cart-attached-files" data-charge="<?php echo $option->file_options->charge ? 1 : 0; ?>"
                data-quantity="<?php echo $option->file_options->quantity ? 1 : 0; ?>">
        <?php
            foreach ($option->attachments as $attachment) {
        ?>
                <div class="ba-add-to-cart-attachment attachment-file-uploaded" data-id="<?php echo $attachment->id; ?>"
                    data-attachment="<?php echo $attachment->attachment_id; ?>">
        <?php
                if ($attachment->isImage) {
                    $src = JUri::root().self::$storeHelper->attachments.'/'.$attachment->filename;
        ?>
                    <span class="post-intro-image" style="background-image: url(<?php echo $src; ?>);" data-image="<?php echo $src; ?>"></span>
        <?php
                } else {
        ?>
                    <i class="ba-icons ba-icon-attachment"></i>
        <?php
                }
        ?>
                    <span class="attachment-title"><?php echo $attachment->name; ?></span>
                    <span class="attachment-progress-bar-wrapper">
                        <span class="attachment-progress-bar" style="width: 100%;"></span>
                    </span>
                    <i class="ba-icons ba-icon-trash remove-attachment-file"></i>
                </div>
        <?php
            }
        ?>
            </div>
        </div>
<?php
        }
        foreach ($option->items as $item) {
            if ($isFile || $option->type == 'textarea' || $option->type == 'textinput') {
                break;
            }
            if ($item->price != '') {
                $price = self::preparePrice($item->price, $currency->thousand, $currency->separator, $currency->decimals);
                if ($currency->position == '') {
                    $price = $currency->symbol.' '.$price;
                } else {
                    $price = $price.' '.$currency->symbol;
                }
            } else {
                $price = '';
            }
            if ($option->type == 'dropdown' || $option->type == 'radio' || $option->type == 'checkbox') {
                $price = '<span class="extra-option-price">'.$price.'</span>';
            }
            $text = $item->title.' '.$price;
            if ($option->type == 'dropdown') {
                if ($item->default) {
                    $textValue = strip_tags($text);
                    $value = $item->key;
                }
                $li .= '<li data-value="'.$item->key.'" class="'.($item->default ? 'selected' : '').'">'.$text.'</li>';
            } else if ($option->type == 'tag') {
?>
                <span data-value="<?php echo $item->key; ?>" class="<?php echo $item->default ? 'active' : ''; ?>">
                    <?php echo $text; ?>
                </span>
<?php
            } else if ($option->type == 'color') {
?>
                <span data-value="<?php echo $item->key; ?>" class="<?php echo $item->default ? 'active' : ''; ?>">
                    <span style="--variation-color-value: <?php echo $item->color; ?>;"></span>
                    <span class="ba-tooltip ba-top"><?php echo $text; ?></span>
                </span>
<?php
            }  else if ($option->type == 'image') {
                $image = !gridboxHelper::isExternal($item->image) ? JUri::root().$item->image : $item->image;
?>
                <span data-value="<?php echo $item->key; ?>" class="<?php echo $item->default ? 'active' : ''; ?>">
                    <span style="--variation-image-value: url(<?php echo $image; ?>);"></span>
                    <span class="ba-tooltip ba-top"><?php echo $text; ?></span>
                </span>
<?php
            } else if ($option->type == 'radio' || $option->type == 'checkbox') {
?>
                <div class="ba-checkbox-wrapper">
                    <span><?php echo $text; ?></span>
                    <label class="ba-<?php echo $option->type; ?>">
                        <input type="<?php echo $option->type; ?>" name="<?php echo $option_id; ?>"
                            class="<?php echo $item->default ? 'active' : ''; ?>"
                            value="<?php echo $item->key; ?>"<?php echo $item->default ? ' checked' : ''; ?>>
                        <span></span>
                    </label>
                </div>
<?php
            }
        }
        if ($option->type == 'dropdown') {
?>
            <div class="ba-custom-select">
            <input readonly="" onfocus="this.blur()" type="text" value="<?php echo $textValue; ?>">
            <input type="hidden" value="<?php echo $value; ?>">
            <i class="ba-icons ba-icon-caret-down"></i>
            <ul><?php echo $li; ?></ul>
        </div>
<?php
        }
?>
    </div>
</div>
<?php
}
$min = $hasFileQty ? $fileQty : $min;
?>
</div>
<div class="ba-add-to-cart-info">
    <div class="ba-add-to-cart-sku">
        <div class="ba-add-to-cart-row-label">
            <?php echo JText::_('SKU'); ?>
        </div>
        <div class="ba-add-to-cart-row-value">
            <?php echo $sku; ?>
        </div>
    </div>
    <div class="ba-add-to-cart-stock">
        <div class="ba-add-to-cart-row-label">
            <?php echo JText::_('IN_STOCK'); ?>
        </div>
        <div class="ba-add-to-cart-row-value">
            <?php echo $stock; ?>
        </div>
    </div>
</div>
<div class="ba-add-to-cart-price">
<?php
if ($prices->sale !== '') {
    
?>
    <span class="ba-add-to-cart-sale-price-wrapper <?php echo $currency->position; ?>">
        <span class="ba-add-to-cart-price-currency"><?php echo $currency->symbol; ?></span>
        <span class="ba-add-to-cart-price-value"><?php echo $prices->sale; ?></span>
    </span>
<?php
}
?>
    <span class="ba-add-to-cart-price-wrapper <?php echo $currency->position; ?>">
        <span class="ba-add-to-cart-price-currency"><?php echo $currency->symbol; ?></span>
        <span class="ba-add-to-cart-price-value"><?php echo $prices->regular; ?></span>
    </span>
</div>
<div class="ba-add-to-cart-button-wrapper<?php echo $disabled; ?>">
<?php
if (!isset($data->product_type) || ($data->product_type != 'digital' && $data->product_type != 'subscription')) {
?>
    <div class="ba-add-to-cart-quantity<?php echo $hasFileQty ? ' file-quantity-enabled' : ''; ?>">
        <i class="ba-icons ba-icon-minus" data-action="-"></i>
        <input type="text" value="<?php echo $min; ?>">
        <i class="ba-icons ba-icon-plus" data-action="+"></i>
    </div>
<?php
}
?>
    <div class="ba-add-to-cart-buttons-wrapper">
        <a class="ba-btn-transition" href="#"><?php echo $btn; ?></a>
        <span class="ba-add-to-wishlist">
            <i class="ba-icons ba-icon-heart"></i>
            <span class="ba-tooltip ba-top"><?php echo JText::_('ADD_TO_WISHLIST'); ?></span>
        </span>
    </div>
</div>
<?php
$out = ob_get_contents();
ob_end_clean();