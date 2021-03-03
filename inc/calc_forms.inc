<?
	$GLOBALS['calc_forms'] = array(
		'rect' => array(
			'caption' => 'Прямоугольный',
			'hint' => 'Расчет простого прямоугольного потолка',
			'icon_svg' => '<rect x="1" y="1" width="14" height="14" stroke="black" fill="transparent" stroke-width="2"/>',
			'controls' => array(
				'material' => array(
					'caption' => 'Материал',
					'type' => 'combobox',
					'source' => 'films',
					'default' => 'def_film',
					'singleline' => 1,
					'extra' => 'width',
					'suffix' => ' м.'
				),
				'profile' => array(
					'caption' => 'Профиль',
					'type' => 'combobox',
					'source' => 'profiles',
					'default' => 'def_profile',
					'singleline' => 1,
					'strict' => 1,
					'extra' => 'hint'
				),
				'decor' => array(
					'caption' => 'Декор',
					'type' => 'combobox',
					'source' => 'decors',
					'singleline' => 0,
					'extra' => 'hint',
					'allow_null' => 'true'
				),
				'length' => array(
					'caption' => 'Длина',
					'type' => 'number',
					'measure' => 'м.',
					'required' => 1,
					'max' => 99, 
					'min' => 0.1,
					'step' => 0.01
				),
				'width' => array(
					'caption' => 'Ширина',
					'type' => 'number',
					'measure' => 'м.',
					'required' => 1,
					'max' => 99, 
					'min' => 0.1,
					'step' => 0.01
				),
				'lamp' => array(
					'caption' => 'Точки света',
					'type' => 'number',
					'measure' => 'шт.',
					'max' => 99, 
					'min' => 0,
					'step' => 1
				),
				'pipe' => array(
					'caption' => 'Трубы/вентиляции',
					'type' => 'number',
					'measure' => 'шт.',
					'max' => 99, 
					'min' => 0,
					'step' => 1 
				),
				'hard_surface' => array(
					'caption' => 'Сложная поверхность',
					'type' => 'combobox',
					'source' => 'surfaces',
					'default' => 'def_surface',
					'singleline' => 0,
					'extra' => 'hint',
					'allow_null' => 'true'
				),				
				'.center' => array(
					'caption' => 'Центровка',
					'type' => 'checkbox'
				),
				'.comb' => array(
					'caption' => 'Комбинирование',
					'type' => 'checkbox'
				)
			)
		),
		'lshaped' => array(
			'caption' => '-образный',
			'hint' => 'L-образный',
			'icon_img' => '/img/l-shaped.svg',
//			'icon_svg' => '<path d="M7 1 a 8 8, 0, 0, 1, 8 7 v7 h-6 a 8 8, 0, 0, 0, -8 -8 v-6 Z" stroke="black" stroke-width="2" fill="transparent"/>',
			'controls' => array(
				'material' => array(
					'caption' => 'Материал',
					'type' => 'combobox',
					'source' => 'films',
					'default' => 'def_film',
					'singleline' => 1,
					'extra' => 'width',
					'suffix' => ' м.'
				),
				'profile' => array(
					'caption' => 'Профиль',
					'type' => 'combobox',
					'source' => 'profiles',
					'default' => 'def_profile',
					'singleline' => 1,
					'strict' => 1,
					'extra' => 'hint'
				),
				'decor' => array(
					'caption' => 'Декор',
					'type' => 'combobox',
					'source' => 'decors',
					'singleline' => 0,
					'extra' => 'hint',
					'allow_null' => 'true'
				),
				'length' => array(
					'caption' => 'Длина',
					'type' => 'number',
					'measure' => 'м.',
					'required' => 1,
					'max' => 99, 
					'min' => 0.2,
					'step' => 0.01
				),
				'width' => array(
					'caption' => 'Ширина',
					'type' => 'number',
					'measure' => 'м.',
					'required' => 1,
					'max' => 99, 
					'min' => 0.2,
					'step' => 0.01
				),
				'cut_length' => array(
					'caption' => 'Длина выреза',
					'type' => 'number',
					'measure' => 'м.',
					'required' => 1,
					'max' => 99, 
					'min' => 0.2,
					'step' => 0.01
				),
				'cut_width' => array(
					'caption' => 'Ширина выреза',
					'type' => 'number',
					'measure' => 'м.',
					'required' => 1,
					'max' => 99, 
					'min' => 0.2,
					'step' => 0.01
				),
				'lamp' => array(
					'caption' => 'Точки света',
					'type' => 'number',
					'measure' => 'шт.',
					'max' => 99, 
					'min' => 0,
					'step' => 1
				),
				'pipe' => array(
					'caption' => 'Трубы/вентиляции',
					'type' => 'number',
					'measure' => 'шт.',
					'max' => 99, 
					'min' => 0,
					'step' => 1 
				),
				'hard_surface' => array(
					'caption' => 'Сложная поверхность',
					'type' => 'combobox',
					'source' => 'surfaces',
					'default' => 'def_surface',
					'singleline' => 0,
					'extra' => 'hint',
					'allow_null' => 'true'
				),				
				'.center' => array(
					'caption' => 'Центровка',
					'type' => 'checkbox'
				),
				'.comb' => array(
					'caption' => 'Комбинирование',
					'type' => 'checkbox'
				)
			)
		),
		'circle' => array(
			'caption' => 'Круглый',
			'hint' => 'Расчет круглого потолка через его диаметр',
			'icon_svg' => '<circle cx="8" cy="8" r="7" stroke="black" fill="transparent" stroke-width="2"/>',
			'controls' => array(
				'material' => array(
					'caption' => 'Материал',
					'type' => 'combobox',
					'source' => 'films',
					'default' => 'def_film',
					'singleline' => 1,
					'extra' => 'width',
					'suffix' => ' м.'
				),
				'profile' => array(
					'caption' => 'Профиль',
					'type' => 'combobox',
					'source' => 'profiles',
					'default' => 'def_profile',
					'singleline' => 1,
					'strict' => 1,
					'extra' => 'hint'
				),
				'decor' => array(
					'caption' => 'Декор',
					'type' => 'combobox',
					'source' => 'decors',
					'singleline' => 0,
					'extra' => 'hint',
					'allow_null' => 'true'
				),
				'diameter' => array(
					'caption' => 'Диаметр',
					'type' => 'number',
					'measure' => 'м.',
					'required' => 1,
					'max' => 20, 
					'min' => 0.2,
					'step' => 0.05
				),
				'lamp' => array(
					'caption' => 'Точки света',
					'type' => 'number',
					'measure' => 'шт.',
					'max' => 99, 
					'min' => 0,
					'step' => 1
				)
			)
		),
		'custom' => array(
			'caption' => 'Произвольный',
			'hint' => 'Детальный расчет по всем параметрам',
			'icon_img' => '/img/hexagon.svg',
//			'icon_svg' => '<path d="M7 1 a 8 8, 0, 0, 1, 8 7 v7 h-6 a 8 8, 0, 0, 0, -8 -8 v-6 Z" stroke="black" stroke-width="2" fill="transparent"/>',
			'controls' => array(
				'material' => array(
					'caption' => 'Материал',
					'type' => 'combobox',
					'source' => 'films',
					'default' => 'def_film',
					'singleline' => 1,
					'extra' => 'width',
					'suffix' => ' м.'
				),
				'profile' => array(
					'caption' => 'Профиль',
					'type' => 'combobox',
					'source' => 'profiles',
					'default' => 'def_profile',
					'singleline' => 1,
					'strict' => 1,
					'extra' => 'hint'
				),
				'decor' => array(
					'caption' => 'Декор',
					'type' => 'combobox',
					'source' => 'decors',
					'singleline' => 0,
					'extra' => 'hint',
					'allow_null' => 'true'
				),
				'area' => array(
					'caption' => 'Площадь',
					'type' => 'number',
					'measure' => 'м<sup>2</sup>',
					'required' => 1,
					'max' => 999, 
					'min' => 0.2,
					'step' => 0.01
				),
				'perimeter' => array(
					'caption' => 'Периметр',
					'type' => 'number',
					'measure' => 'м.',
					'required' => 0,
					'max' => 999, 
					'min' => 0.4,
					'step' => 0.01
				),
				'corners' => array(
					'caption' => 'Углы',
					'type' => 'number',
					'measure' => 'шт.',
					'required' => 0,
					'max' => 299, 
					'min' => 0,
					'step' => 1
				),				
				'lamp' => array(
					'caption' => 'Точки света',
					'type' => 'number',
					'measure' => 'шт.',
					'max' => 299, 
					'min' => 0,
					'step' => .1
				),
				'pipe' => array(
					'caption' => 'Трубы/вентиляции',
					'type' => 'number',
					'measure' => 'шт.',
					'max' => 99, 
					'min' => 0,
					'step' => .1 
				),
				'curve' => array(
					'caption' => 'Криволинейность',
					'type' => 'number',
					'measure' => 'м.',
					'required' => 0,
					'max' => 499, 
					'min' => 0,
					'step' => 0.01
				),					
				'extra' => array(
					'caption' => 'Дополнительно',
					'type' => 'group',
					'closed' => 1,
					'controls' => array(
						'surface' => array(
							'caption' => 'Поверхность монтажа',
							'type' => 'group',
							'closed' => 1,
							'controls' => array(
								'hard_surface' => array(
									'caption' => 'Сложная поверхность',
									'type' => 'combobox',
									'source' => 'surfaces',
									'default' => 'def_surface',
									'singleline' => 0,
									'extra' => 'hint',
									'allow_null' => 'true'
								),
								'surface_length' => array(
									'caption' => 'Длина сложной поверхности',
									'type' => 'number',
									'measure' => 'м.',
									'max' => 499, 
									'min' => 0,
									'step' => 0.01
								)							
							)
						),
						'curtain-recess' => array(
							'caption' => 'Гардина / ниша',
							'type' => 'group',
							'closed' => 1,
							'controls' => array(
								'curtain' => array(
									'caption' => 'Гардина',
									'type' => 'number',
									'measure' => 'м.',
									'max' => 199, 
									'min' => 0,
									'step' => 0.05
								),
								'recess_curtain' => array(
									'caption' => 'Ниша под гардину',
									'type' => 'number',
									'measure' => 'м.',
									'max' => 199, 
									'min' => 0,
									'step' => 0.05
								),
								'recess' => array(
									'caption' => 'Монтаж потолка в нише',
									'type' => 'number',
									'measure' => 'м.',
									'max' => 199, 
									'min' => 0,
									'step' => 0.01
								),
								'recess_decor' => array(
									'caption' => 'Монтаж декора в нише',
									'type' => 'number',
									'measure' => 'м.',
									'max' => 199, 
									'min' => 0,
									'step' => 0.01
								)							
							)
						),
						'mlevel' => array(
							'caption' => 'Многоуровневые потолки',
							'type' => 'group',
							'closed' => 1,
							'controls' => array(
								'lcross_direct' => array(
									'caption' => 'Переход уровня прямой',
									'type' => 'number',
									'measure' => 'м.',
									'max' => 199, 
									'min' => 0,
									'step' => 0.01
								),
								'lcross_curve' => array(
									'caption' => 'Переход уровня криволинейный',
									'type' => 'number',
									'measure' => 'м.',
									'max' => 199, 
									'min' => 0,
									'step' => 0.01
								)
							)
						),
						'others' => array(
							'caption' => 'Разное',
							'type' => 'group',
							'closed' => 1,
							'controls' => array(
								'decor_length' => array(
									'caption' => 'Длина декора',
									'type' => 'number',
									'measure' => 'м.',
									'max' => 499, 
									'min' => 0,
									'step' => 0.01
								),
								'inner_cut' => array(
									'caption' => 'Внутренний вырез',
									'type' => 'number',
									'measure' => 'м.',
									'max' => 199, 
									'min' => 0,
									'step' => 0.01
								),
								'complex_corner' => array(
									'caption' => 'Сложные углы',
									'type' => 'number',
									'measure' => 'шт.',
									'max' => 99, 
									'min' => 0,
									'step' => 1
								),
								'cond' => array(
									'caption' => 'Обход кондиционера',
									'type' => 'number',
									'measure' => 'шт.',
									'max' => 9, 
									'min' => 0,
									'step' => 0.1
								),								
								'center' => array(
									'caption' => 'Центровка',
									'type' => 'checkbox'
								),
								'comb' => array(
									'caption' => 'Комбинирование',
									'type' => 'checkbox'
								),
								'high_height' => array(
									'caption' => 'Доплата за высоту',
									'type' => 'checkbox'
								)
							)
						),
						'additionally' => array(
							'caption' => 'Дополнительно',
							'type' => 'group',
							'closed' => 1,
							'controls' => array(
								'material2' => array(
									'caption' => 'Материал',
									'type' => 'combobox',
									'source' => 'films',
									'default' => 'def_film',
									'singleline' => 1,
									'extra' => 'width',
									'suffix' => ' м.'
								),
								'area2' => array(
									'caption' => 'Площадь',
									'type' => 'number',
									'measure' => 'м<sup>2</sup>',
									'max' => 999, 
									'min' => 0,
									'step' => 0.01
								),
								'profile2' => array(
									'caption' => 'Профиль',
									'type' => 'combobox',
									'source' => 'profiles',
									'default' => 'def_profile',
									'singleline' => 1,
									'extra' => 'hint'
								),
								'profile2_count' => array(
									'caption' => 'Длина профиля',
									'type' => 'number',
									'measure' => 'м.',
									'max' => 199, 
									'min' => 0,
									'step' => 0.01
								),
								'decor2' => array(
									'caption' => 'Декор',
									'type' => 'combobox',
									'source' => 'decors',
									'singleline' => 0,
									'extra' => 'hint',
									'allow_null' => 'false'
								),
								'decor2_count' => array(
									'caption' => 'Длина декора',
									'type' => 'number',
									'measure' => 'м.',
									'max' => 199, 
									'min' => 0,
									'step' => 0.01
								)
							)
						)
					)
				)
			)
		)
	);
?>