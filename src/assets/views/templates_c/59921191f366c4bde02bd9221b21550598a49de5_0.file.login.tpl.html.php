<?php
/* Smarty version 3.1.36, created on 2020-08-03 12:33:21
  from '/Users/gui/Projects/bbq/src/assets/views/templates/login.tpl.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_5f2804116d46c0_38797282',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '59921191f366c4bde02bd9221b21550598a49de5' => 
    array (
      0 => '/Users/gui/Projects/bbq/src/assets/views/templates/login.tpl.html',
      1 => 1596457992,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f2804116d46c0_38797282 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF8">
    </head>
    <body>
        <form action="/auth" method="POST">
            <div>
                <div>
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" />
                </div>
                <div>
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" />
                </div>
                <div><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['message']->value, ENT_QUOTES, 'UTF-8', true);?>
</div>
            </div>
            <input type="submit" value="Submit"/> 
        </form>
    </body>
</html><?php }
}
