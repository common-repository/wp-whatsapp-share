<?php
/*
Plugin Name: Share by Chat Message (Pages & Posts)
Plugin URI: https://danielesparza.studio/wp-whatsapp-share/
Description: Share by Chat Message (Pages & Posts), antes "Whatsapp Share", es un plugin para WordPress que permite compartir nuestras páginas o publicaciónes en WhatsApp a través del uso de un shortcode.
Version: 1.0
Author: Daniel Esparza
Author URI: https://odanielesparza.studio/
License: GPL v3

Share by Chat Message (Pages & Posts)
Copyright (C) 2019, OneClouding | Consultoría en servicios y soluciones integrales de entorno web. - https://oneclouding.com/

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

if(function_exists('admin_menu_desparza')) { 
    //menu exist
} else {
	add_action('admin_menu', 'admin_menu_desparza');
	function admin_menu_desparza(){
		add_menu_page('DE Plugins', 'DE Plugins', 'manage_options', 'desparza-menu', 'wp_desparza_function', 'dashicons-editor-code', 90 );
		add_submenu_page('desparza-menu', 'Sobre Daniel Esparza', 'Sobre Daniel Esparza', 'manage_options', 'desparza-menu' );
	
    function wp_desparza_function(){  	
	?>
		<div class="wrap">
            <h2>Daniel Esparza</h2>
            <p>Consultoría en servicios y soluciones de entorno web.<br>¿Qué tipo de servicio o solución necesita tu negocio?</p>
            <h4>Contact info:</h4>
            <p>
                Sitio web: <a href="https://danielesparza.studio/" target="_blank">https://danielesparza.studio/</a><br>
                Contacto: <a href="mailto:hi@danielesparza.studio" target="_blank">hi@danielesparza.studio</a><br>
                Messenger: <a href="https://www.messenger.com/t/danielesparza.studio" target="_blank">enviar mensaje</a><br>
                Información acerca del plugin: <a href="https://danielesparza.studio/wp-whatsapp-share/" target="_blank">sitio web del plugin</a><br>
                Daniel Esparza | Consultoría en servicios y soluciones de entorno web.<br>
                ©2020 Daniel Esparza, inspirado por #openliveit #dannydshore
            </p>
		</div>
	<?php }
        
    }	
    
    add_action( 'admin_enqueue_scripts', 'wpscm_register_adminstyle' );
    function wpscm_register_adminstyle() {
        wp_register_style( 'wpscm_register_adminstyle_css', plugin_dir_url( __FILE__ ) . 'css/wpscm_style_admin.css', array(), '1.0' );
        wp_enqueue_style( 'wpscm_register_adminstyle_css' );
    }
    
}


if ( ! function_exists( 'scm_sharemessage_add' ) ) {

add_action( 'admin_menu', 'scm_sharemessage_add' );
function scm_sharemessage_add() {
    add_submenu_page('desparza-menu', 'Share Chat Message', 'Share Chat Message', 'manage_options', 'scm-sharemessage-add-settings', 'scm_sharemessage_how_to_use' );
}

function scm_sharemessage_how_to_use(){ 
    
    echo '
    <div class="wrap">
        <h2>Share by Chat Message (Pages & Posts), ¿Como usar el shortcode?</h2>
        <ul>
            <li>[scm-pp] // Configruación por defecto.</li>
            <li>[scm-pp class="nombre de la clase"] // Agrgando una clase para cambiar los estilos CSS.</li>
            <li>[scm-pp icon="url de la imagen"] // Cambiando la imagen por defecto.</li>
            <li>[scm-pp text="lorem ipsum dolor"] // Cambiando el texto del enlace por defecto.</li>
        </ul>
        <h4>Share by Chat Message (Pages & Posts), Otras funciones:</h4>
        <ul>
            <li>[scm-pp class=" "] // Deshabilitar solo los estilos CSS.</li>
        </ul>
        <h4>Para un mejor funcionamiento:</h4>
        <ul>
            <li>- Agregar una imagen predeterminada a la página o publicación.</li>
            <li>- Agregar una descripción a la página o publicación.</li>
        </ul>
        <p>Puedes buscar un plugin de terceros para agregar esta información <a href="https://es.wordpress.org/plugins/search/meta+post+page/" target="_blank">Plugin para añadir metas</a>.</p>
    </div>';
    
}

// Add Style
add_action('wp_enqueue_scripts', 'scm_sharemessage_style');
function scm_sharemessage_style() {
    wp_register_style( 'wp_wapp_share_css', plugin_dir_url( __FILE__ ) . 'css/wpscm_style.css' );
    wp_enqueue_style( 'wp_wapp_share_css' );
}

// Add Shortcode
add_shortcode( 'scm-pp', 'scm_sharemessage_shortcode' );
function scm_sharemessage_shortcode($atts, $content = null) {
extract( shortcode_atts( array(
      'icon' =>  plugin_dir_url( __FILE__ ) . 'img/share-chat-message.svg',
      'text' => 'Compartir en WhatsApp',
      'class' => 'share-chat-message'
      ), $atts ) );
		?>
			<a class="<?php echo esc_attr($class) ?>" href="whatsapp://send?text=<?php the_title(); ?> – <?php urlencode(the_permalink()); ?>" data-action="share/whatsapp/share"><img src="<?php echo $icon; ?>"><?php echo ' ' . $text; ?></a>
		<?php
}
}