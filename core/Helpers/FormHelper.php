<?php

namespace Codemanas\Webex\Core\Helpers;

class FormHelper {

	static function fields( $key, $args, $value = null ) {
		$defaults = array(
			'type'              => 'text',
			'label'             => '',
			'description'       => '',
			'placeholder'       => '',
			'maxlength'         => false,
			'required'          => false,
			'autocomplete'      => false,
			'id'                => $key,
			'class'             => array(),
			'options'           => array(),
			'custom_attributes' => array(),
			'validate'          => array(),
			'default'           => '',
			'autofocus'         => false
		);

		$args = wp_parse_args( $args, $defaults );
		$args = apply_filters( 'vcw_formFields', $args, $key, $value );

		$allowed_html = [];
		if ( $args['required'] ) {
			$args['class'][] = 'validate-required';
			$required        = ' <abbr class="required" title="' . __( 'required', 'video-conferencing-webex' ) . '">*</abbr>';

			$allowed_html['abbr'] = [
				'class' => [],
				'title' => []
			];
		} else {
			$required = '';
		}

		if ( is_null( $value ) ) {
			$value = $args['default'];
		}

		// Custom attribute handling
		$custom_attributes         = array();
		$args['custom_attributes'] = array_filter( (array) $args['custom_attributes'] );

		if ( $args['maxlength'] ) {
			$args['custom_attributes']['maxlength'] = absint( $args['maxlength'] );
		}

		if ( true === $args['autofocus'] ) {
			$args['custom_attributes']['autofocus'] = 'autofocus';
		}

		if ( ! empty( $args['custom_attributes'] ) && is_array( $args['custom_attributes'] ) ) {
			foreach ( $args['custom_attributes'] as $attribute => $attribute_value ) {
				$custom_attributes[] = $attribute . '="' . $attribute_value . '"';
			}
		}

		if ( ! empty( $args['validate'] ) ) {
			foreach ( $args['validate'] as $validate ) {
				$args['class'][] = 'validate-' . $validate;
			}
		}

		$field       = '';
		$label_id    = $args['id'];
		$input_class = ! empty( $args['input_class'] ) ? implode( ' ', $args['input_class'] ) : '';

		switch ( $args['type'] ) {
			case 'textarea' :

				$allowed_html['textarea'] = [
					'class'       => [],
					'id'          => [],
					'name'        => [],
					'placeholder' => [],
					'cols'        => [],
					'rows'        => []
				];

				if ( ! empty( $args['custom_attributes'] ) && is_array( $args['custom_attributes'] ) ) {
					foreach ( $args['custom_attributes'] as $attribute => $attribute_value ) {
						$allowed_html['textarea'][ $attribute ] = [];
					}
				}

				$field .= '<textarea name="' . $key . '" class="regular-text ' . $input_class . '" id="' . $args['id'] . '" placeholder="' . $args['placeholder'] . '" ' . ( empty( $args['custom_attributes']['rows'] ) ? ' rows="2"' : '' ) . ( empty( $args['custom_attributes']['cols'] ) ? ' cols="5"' : '' ) . implode( ' ', $custom_attributes ) . '>' . $value . '</textarea>';

				break;
			case 'checkbox' :

				$allowed_html['input'] = [
					'class'   => [],
					'type'    => [],
					'id'      => [],
					'name'    => [],
					'value'   => [],
					'checked' => []
				];

				$field = '<label class="checkbox" ' . implode( ' ', $custom_attributes ) . '> 
                    <input type="' . $args['type'] . '" class="input-checkbox ' . $input_class . '" name="' . $key . '" id="' . $args['id'] . '" value="1" ' . checked( $value, 1, false ) . ' /> '
				         . $args['label'] . $required . '</label>';

				break;
			case 'password' :
			case 'text' :
			case 'email' :
			case 'tel' :
			case 'number' :

				$allowed_html['input'] = [
					'class'       => [],
					'type'        => [],
					'id'          => [],
					'name'        => [],
					'placeholder' => [],
					'value'       => []
				];

				if ( ! empty( $args['custom_attributes'] ) && is_array( $args['custom_attributes'] ) ) {
					foreach ( $args['custom_attributes'] as $attribute => $attribute_value ) {
						$allowed_html['input'][ $attribute ] = [];
					}
				}

				$field .= '<input type="' . $args['type'] . '" class="regular-text ' . $input_class . '" name="' . $key . '" id="' . $args['id'] . '" placeholder="' . $args['placeholder'] . '"  value="' . $value . '" ' . implode( ' ', $custom_attributes ) . ' />';

				break;
			case 'select' :

				$allowed_html['select'] = [
					'class'            => [],
					'id'               => [],
					'name'             => [],
					'value'            => [],
					'data-placeholder' => []
				];

				$allowed_html['option'] = [
					'value'    => [],
					'selected' => []
				];

				if ( ! empty( $args['custom_attributes'] ) && is_array( $args['custom_attributes'] ) ) {
					foreach ( $args['custom_attributes'] as $attribute => $attribute_value ) {
						$allowed_html['select'][ $attribute ] = [];
					}
				}

				$options = $field = '';

				if ( ! empty( $args['options'] ) ) {
					foreach ( $args['options'] as $option_key => $option_text ) {
						if ( '' === $option_key ) {
							// If we have a blank option, select2 needs a placeholder
							if ( empty( $args['placeholder'] ) ) {
								$args['placeholder'] = $option_text ? $option_text : __( 'Choose an option', 'video-conferencing-webex' );
							}
							$custom_attributes[] = 'data-allow_clear="true"';
						}
						$options .= '<option value="' . $option_key . '" ' . selected( $value, $option_key, false ) . '>' . $option_text . '</option>';
					}

					$field .= '<select name="' . $key . '" id="' . $args['id'] . '" class="select ' . $input_class . '" ' . implode( ' ', $custom_attributes ) . ' data-placeholder="' . $args['placeholder'] . '"> 
                        ' . $options . ' 
                    </select>';
				}

				break;
			case 'radio' :

				$allowed_html['input'] = [
					'class'   => [],
					'type'    => [],
					'id'      => [],
					'name'    => [],
					'value'   => [],
					'checked' => []
				];
				$allowed_html['div']   = [
					'class' => [],
					'id'    => [],
					'style' => []
				];

				$label_id = current( array_keys( $args['options'] ) );

				if ( ! empty( $args['options'] ) ) {
					foreach ( $args['options'] as $option_key => $option_text ) {
						$field .= '<div style="margin:10px 0;"><input type="radio" class="input-radio ' . $input_class . '" value="' . $option_key . '" name="' . $key . '" id="' . $args['id'] . '_' . $option_key . '" ' . checked( $value, $option_key, false ) . '/>';
						$field .= '<label for="' . $args['id'] . '_' . $option_key . '" class="radio">' . $option_text . '</label></div>';
					}
				}

				break;
		}

		if ( ! empty( $field ) ) {
			$field_html = '';

			if ( $args['label'] && 'checkbox' != $args['type'] ) {
				$field_html .= '<label for="' . $label_id . '" class="' . implode( ' ', $args['label_class'] ) . '">' . $args['label'] . $required . '</label>';
			}

			$field_html .= $field;

			if ( $args['description'] ) {
				$field_html .= '<p class="description">' . $args['description'] . '</p>';
			}

			if ( ! empty( $args['after_html'] ) ) {
				$field_html .= '<span style="color: #8a8a8a;"><i>' . $args['after_html'] . '</i></span>';
			}

			$field = $field_html;
		}

		$field = apply_filters( 'vcw_formField_' . $args['type'], $field, $key, $args, $value );

		$allowed_html['label']  = [
			'for'   => [],
			'class' => [],
			'id'    => []
		];
		$allowed_html['a']      = [
			'href'  => [],
			'title' => [],
			'class' => [],
			'id'    => []
		];
		$allowed_html['p']      = [
			'class' => [],
			'id'    => []
		];
		$allowed_html['br']     = [];
		$allowed_html['em']     = [];
		$allowed_html['strong'] = [];
		$allowed_html['span']   = [
			'class' => [],
			'id'    => [],
			'style' => []
		];

		echo wp_kses( $field, $allowed_html );
	}

}