<?php
/**
Plugin Name: PDF Meta parser
Version: 1.0
Description: <a href="http://www.pdfparser.org/">PDF Parser</a> implementation for Wordpress attachments.
Author: Kaido Toomingas
License: GPLv2 or later
Text Domain: pdf_meta_parser
 */
/*
* This program is free software; you can redistribute it and/or
* modify it under the terms of the GNU General Public License
* as published by the Free Software Foundation; either version 2
* of the License, or (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with this program; if not, write to the Free Software
* Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
* */

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
require_once __DIR__ . '/vendor' . '/autoload.php';

function pdf_meta_parser_pdf_attachment_extract($post_id) {

  $post = get_post($post_id);
    if( isset($post->post_mime_type) && $post->post_mime_type == 'application/pdf'){
      // update_post_meta(postID, meta_key, meta_value);
        $parser = new \Smalot\PdfParser\Parser();
        $file = get_attached_file( $post_id );
        $pdf    = $parser->parseFile($file);
        $text = trim($pdf->getText());
        update_post_meta($post_id, '_pdf-metaparser-content', $text);
    }
}
// now attach our function to the hook.
add_action("add_attachment", "pdf_meta_parser_pdf_attachment_extract");

