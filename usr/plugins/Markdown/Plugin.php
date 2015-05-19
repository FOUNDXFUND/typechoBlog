<?php
/**
 * 0.该插件是在 明城<i.feelinglucky@gmail.com> 的“使用 Markdown 解析器”的基础上完善的。
 * 1.使用 <a href="http://daringfireball.net/projects/markdown/" target="_blank">Markdown 语法</a>编写和发布文章。
 * 2.在正文上方加入了简单的格式按钮；
 * 3.tab键自动输入4个空格；
 * 4.正文下方加入了预览功能；
 * 5.在侧边栏加入了语法提示。
 * 
 * @package 使用 Markdown 解析器 + 编辑器
 * @author 勾三股四<zhaojinjiang@yahoo.com.cn>
 * @version 1.1.1
 * @link http://jiongks.name/
 */

require_once 'markdown.php';

class Markdown_Plugin implements Typecho_Plugin_Interface
{
    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     * 
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function activate() {
        Typecho_Plugin::factory('admin/write-post.php')->content = array('Markdown_Plugin', 'render');
        Typecho_Plugin::factory('admin/write-page.php')->content = array('Markdown_Plugin', 'render');
        Typecho_Plugin::factory('admin/write-post.php')->option = array('Markdown_Plugin', 'renderOption');
        Typecho_Plugin::factory('admin/write-page.php')->option = array('Markdown_Plugin', 'renderOption');
        Typecho_Plugin::factory('Widget_Abstract_Contents')->excerpt = array('Markdown_Plugin', 'parse');
        Typecho_Plugin::factory('Widget_Abstract_Contents')->content = array('Markdown_Plugin', 'parse');

        // TODO 上传附件后的图片/链接的格式待转换
    }
 
    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     * 
     * @static
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function deactivate() {
    
    }

    /**
     * 获取插件配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form)
    {

    }

    /**
     * 个人用户的配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form){}
 
 
    /**
     * 插件实现方法
     * 
     * @access public
     * @return void
     */
    public static function parse($text, $widget, $lastResult) {
        $text = empty($lastResult) ? $text : $lastResult;
        return Markdown(trim($text));
    }

    /**
     * 插件实现方法
     * 
     * @access public
     * @return void
     */
    public static function render() {
        $options = Helper::options();
        $ajax_url = Typecho_Common::url('Markdown/preview.php', $options->pluginUrl);
        include_once(dirname(__FILE__).'/editor-js.php');
        include_once(dirname(__FILE__).'/preview-html.php');
        include_once(dirname(__FILE__).'/preview-js.php');
    }

    /**
     * 插件实现方法
     * 
     * @access public
     * @return void
     */
    public static function renderOption() {
        include_once(dirname(__FILE__).'/sidebar-html.php');
    }
}
