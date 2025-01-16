/* @license
See the license.txt file for licensing information for third-party code that may be used in this file.
Relative to the scripts/ directory, the license.txt file is located at ../license.txt.
This file (or the corresponding source JS file) has been modified by Jonathan Hall and/or others.
This file (or the corresponding source JS file) was last modified 2020-11-25
*/
/*
	This file is from the submodule-builder repository.
*/

const reinitAttrsLists = {
  slider: [
    'arrows_custom_color',
    'arrows_custom_color_tablet',
    'arrows_custom_color_phone',
    'auto',
    'auto_ignore_hover',
    'auto_speed',
    'body_font_size',
    'body_font_size_phone',
    'body_font_size_tablet',
    'button_border_width',
    'button_icon',
    'button_text_size',
    'button_text_size_phone',
    'button_text_size_tablet',
    'custom_button',
    'dot_nav_custom_color',
    'dot_nav_custom_color_tablet',
    'dot_nav_custom_color_phone',
    'header_font_size',
    'header_font_size_phone',
    'header_font_size_tablet',
    'image_placement',
    'parallax',
    'parallax_method',
    'show_arrows',
    'show_image',
    'show_pagination',
    'custom_padding',
    'custom_padding_phone',
    'custom_padding_tablet',
    'width',
    'width__hover',
    'width_tablet',
    'width_phone',
    'max_width',
    'max_width__hover',
    'max_width_tablet',
    'max_width_phone',
    'content_width',
    'content_width__hover',
    'content_width_tablet',
    'content_width_phone',
    'content_max_width',
    'content_max_width__hover',
    'content_max_width_tablet',
    'content_max_width_phone',
    'height',
    'height__hover',
    'height_tablet',
    'height_phone',
    'min_height',
    'min_height__hover',
    'min_height_tablet',
    'min_height_phone',
    'max_height',
    'max_height__hover',
    'max_height_tablet',
    'max_height_phone',
  ],
  videoBackground: [
    'background_video_mp4',
    'background_video_webm',
    'background_video_width',
    'background_video_height',
    'allow_player_pause',
    'background_video_pause_outside_viewport',
  ],
  unifiedBackground: [
    'background_video_mp4',
    'background_video_webm',
    'background_video_width',
    'background_video_height',
    'allow_player_pause',
    'background_video_pause_outside_viewport',
    'background_image',
    'parallax',
    'parallax_method',
  ],
  postTitleBackground: [
    'parallax',
    'parallax_method',
    'featured_image',
  ],
  borderOptions: [
    'border_width_all',
    'border_width_top',
    'border_width_right',
    'border_width_bottom',
    'border_width_left',
  ],
  width: [
    'max_width',
    'max_width_tablet',
    'max_width_phone',
    'max_width_last_edited',
  ],
};

const getReinitAttrsList = module => ((module in reinitAttrsLists) ? reinitAttrsLists[module] : []);

export default getReinitAttrsList;
