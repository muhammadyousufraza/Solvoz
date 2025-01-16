(function( $ ){
    let total_filter_data = {};
    const dfMultiFilter = {
        multiple_filter_data: {},
        multi_filter_selector: null,
        multi_filter_acf_selector: null,
        multi_filter_selected_elements: null,
        selectBox: null,
        grid_container: null,
        selector: null,
        current_column:null,
        search_key:'',
        init: function(element , ele , current_column , search_key ='') {  
            dfMultiFilter.grid_container = ele.querySelector('.df-cpts-wrap');
            dfMultiFilter.selector = ele.querySelector('.df-cpts-inner-wrap');
            dfMultiFilter.search_key = '' !== search_key ? search_key: '';
            dfMultiFilter.ele_class = ele.classList.value.split(" ").filter(function(class_name){
                return class_name.indexOf('difl_cptfilter_') !== -1;
            });
            dfMultiFilter.multi_filter_selector = ele.querySelectorAll('li.multiple_taxonomy_filter');
            dfMultiFilter.multi_filter_acf_selector = ele.querySelector('.filter_section');
            dfMultiFilter.multi_filter_selected_elements = dfMultiFilter.multi_filter_acf_selector.querySelector('.filter_elements');
            dfMultiFilter.multi_filter_acf_selector.addEventListener("click", this.clickOnFilterRadio);
            const wrapper = document.createElement("div");
            wrapper.addEventListener("click", this.clickOnWrapper);
            wrapper.classList.add("multi-select-component");
        
            // Create elements of search
            const search_div = document.createElement("div");
            search_div.classList.add("search-container");
            const input = document.createElement("input");
            input.classList.add("selected-input");
            input.setAttribute("autocomplete", "off");
            input.setAttribute("tabindex", "0");
            input.addEventListener("keyup", this.inputChange);
            input.addEventListener("keydown", this.deletePressed);
            input.addEventListener("click", this.openOptions);
            dfMultiFilter.selectBox = input;
            const dropdown_icon = document.createElement("a");
            dropdown_icon.setAttribute("href", "javascript:void(0);");
            dropdown_icon.classList.add("dropdown-icon");
            dropdown_icon.addEventListener("click", this.clickDropdown);
            const autocomplete_list = document.createElement("ul");
            autocomplete_list.classList.add("autocomplete-list")
            search_div.appendChild(input);
            search_div.appendChild(autocomplete_list);
            search_div.appendChild(dropdown_icon);
        
            // set the wrapper as child (instead of the element)
            element.parentNode.replaceChild(wrapper, element);
            // set element as child of wrapper
            wrapper.appendChild(element);
            wrapper.appendChild(search_div);
            // display the modal
            this.createInitialTokens(element);
            this.addPlaceholder(wrapper);
        },

        removePlaceholder: function(wrapper){
            const input_search = wrapper.querySelector(".selected-input");
            input_search.removeAttribute("placeholder");
        },
        
        addPlaceholder: function(wrapper) {
            const input_search = wrapper.querySelector(".selected-input");
            const term_title = wrapper.querySelector('select[title]').getAttribute("title");
            const tokens = wrapper.querySelectorAll(".selected-wrapper");
            const prefex_text = df_cpt_filter[dfMultiFilter.ele_class[0]]? df_cpt_filter[dfMultiFilter.ele_class[0]].multi_filter_dropdown_placeholder_prefix + ' ' : '';
            if (!tokens.length && !(document.activeElement === input_search))
                input_search.setAttribute("placeholder", prefex_text + term_title);
        },
        
        
        // Function that create the initial set of tokens with the options selected by the users
        createInitialTokens: function(element) {
            let options_selected = dfMultiFilter.getOptions(element).options_selected;

            const wrapper = element.parentNode;
            for (let i = 0; i < options_selected.length; i++) {
                dfMultiFilter.createToken(wrapper, key, value);
            }
        },
        inputChange : function(e){
            const wrapper = e.target.parentNode.parentNode;
            const select = wrapper.querySelector("select");
            const dropdown = wrapper.querySelector(".dropdown-icon");
            const input_val = e.target.value;
        
            if (input_val) {
                dropdown.classList.add("active");
                dfMultiFilter.populateAutocompleteList(select, input_val.trim());
            } else {
                dropdown.classList.remove("active");
                const event = new Event('click');
                dropdown.dispatchEvent(event);
            }          
        },
        
        
        // Listen for clicks on the wrapper, if click happens focus on the input
        clickOnWrapper : function(e){
            const wrapper = e.target;
            if (wrapper.tagName == "a") {
                const input_search = wrapper.querySelector(".selected-input");
                const dropdown = wrapper.querySelector(".dropdown-icon");
                if (!dropdown.classList.contains("active")) {
                    const event = new Event('click');
                    dropdown.dispatchEvent(event);
                }
                input_search.focus();
                dfMultiFilter.removePlaceholder(wrapper);
            }
        },
        clickOnFilterRadio: function (e) {
            if ('checkbox' === e.target.type) {
                const uniq_el = e.target.parentNode.parentNode.parentNode.closest('div.difl_cptfilter');
                dfMultiFilter.grid_container = uniq_el.querySelector('.df-cpts-wrap');
                dfMultiFilter.selector = uniq_el.querySelector('.df-cpts-inner-wrap');
                dfMultiFilter.ele_class = uniq_el.classList.value.split(" ").filter(function(class_name){
                    return class_name.indexOf('difl_cptfilter_') !== -1;
                });
                if(e.target.checked){
                    dfMultiFilter.generate_filter_selected_elements(e.target , "", "", "checkbox");
                }else{
                    dfMultiFilter.remove_selected_element_when_remove_from_field(e.target.parentNode.querySelector('input').getAttribute('data-value'))
                }
                process_filter_data(uniq_el, dfMultiFilter.grid_container, dfMultiFilter.ele_class[0], '', dfMultiFilter.selector, 'filter', dfMultiFilter.current_column, dfMultiFilter.search_key);
                // dfMultiFilter.process_filter_data(uniq_el);
                e.stopPropagation();
            }
        },
        
        openOptions: function(e) {
            const input_search = e.target;
            const wrapper = input_search.parentElement.parentElement;
            const dropdown = wrapper.querySelector(".dropdown-icon");
            if (!dropdown.classList.contains("active")) {
                const event = new Event('click');
                dropdown.dispatchEvent(event);
            }
            e.stopPropagation();
        
        },

        createToken :function(wrapper, value, label){
            const search = wrapper.querySelector(".search-container");
            // Create token wrapper
            const token = document.createElement("div");
            token.classList.add("selected-wrapper");
            const token_span = document.createElement("span");
            token_span.classList.add("selected-label");
            token_span.innerText = label;
            const close = document.createElement("a");
            close.classList.add("selected-close");
            close.setAttribute("tabindex", "-1");
            close.setAttribute("data-option", value);
            close.setAttribute("data-hits", 0);
            close.setAttribute("href", "javascript:void(0);");
            close.innerText = "x";
            close.addEventListener("click", dfMultiFilter.removeToken)
            token.appendChild(token_span);
            token.appendChild(close);
            wrapper.insertBefore(token, search);
            dfMultiFilter.generate_filter_selected_elements(wrapper, value, label, 'select');
        },
        
        
        // Listen for clicks in the dropdown option
        clickDropdown : function(e) {
            const dropdown = e.target;
            const wrapper = dropdown.parentNode.parentNode;
            const filter_container = wrapper.parentNode.parentNode
            const input_search = wrapper.querySelector(".selected-input");
            const select = wrapper.querySelector("select");
            const all_multi_select_fields = filter_container.querySelectorAll('.multi-select-component a');
            all_multi_select_fields.forEach(function (field) {
                if (field.classList.contains("active")) {
                    field.classList.remove('active');
                    dfMultiFilter.clearAutocompleteList(field.parentNode.parentNode.querySelector("select"));
                    dfMultiFilter.addPlaceholder(field.parentNode.parentNode);
                }
            })

            dropdown.classList.toggle("active");
            if (dropdown.classList.contains("active")) {
                dfMultiFilter.removePlaceholder(wrapper);
                input_search.focus();
        
                if (!input_search.value) {
                    dfMultiFilter.populateAutocompleteList(select, "", true);             
                } else {
                    dfMultiFilter.populateAutocompleteList(select, input_search.value);
                  
                }              
            } else {
                dfMultiFilter.clearAutocompleteList(select);
                dfMultiFilter.addPlaceholder(wrapper);
            }   
      
        },
        
        
        // Clears the results of the autocomplete list
        clearAutocompleteList: function(select) {
            const wrapper = select.parentNode;
        
            const autocomplete_list = wrapper.querySelector(".autocomplete-list");
            autocomplete_list.innerHTML = "";
        },

        populateAutocompleteList: function(select, query, dropdown = false) {
            const autocomplete_options = dfMultiFilter.getOptions(select).sorted_options;
        
            let options_to_show;

            if (dropdown)
                options_to_show = autocomplete_options;
            else
                options_to_show = dfMultiFilter.autocomplete(query, autocomplete_options);

            const wrapper = select.parentNode;
            const input_search = wrapper.querySelector(".search-container");
            const autocomplete_list = wrapper.querySelector(".autocomplete-list");
            autocomplete_list.innerHTML = "";
            const result_size = Object.keys(options_to_show).length;

            if (result_size >= 1) {
                for (const [key, value] of Object.entries(options_to_show)) {
                    const li = document.createElement("li");
                    li.innerText = value;
                    li.setAttribute('data-value', key);
                    li.addEventListener("click", dfMultiFilter.selectOption);
                    autocomplete_list.appendChild(li);
                }
            }  else {
                const li = document.createElement("li");
                li.classList.add("not-cursor");
                li.innerText = "No options found";
                autocomplete_list.appendChild(li);
            }
        },
               
        // Listener to autocomplete results when clicked set the selected property in the select option 
        selectOption: function(e){
            const wrapper = e.target.parentNode.parentNode.parentNode;
            const input_search = wrapper.querySelector(".selected-input");
            const option = wrapper.querySelector(`select option[value="${e.target.dataset.value}"]`);
            if(option) option.setAttribute("selected", "");

            dfMultiFilter.createToken(wrapper, e.target.dataset.value, e.target.innerText);
            // dfMultiFilter.createToken(wrapper, e.target.innerText);

            if (input_search.value) {
                input_search.value = "";
            }
        
            input_search.focus();
        
            e.target.remove();
            const autocomplete_list = wrapper.querySelector(".autocomplete-list");
        
        
            if (!autocomplete_list.children.length) {
                const li = document.createElement("li");
                li.classList.add("not-cursor");
                li.innerText = "No options found";
                autocomplete_list.appendChild(li);
            }
        
            const event = new Event('keyup');
            input_search.dispatchEvent(event);
         
            //the click was outside the specifiedElement, do something
            const dropdown = wrapper.querySelector(".dropdown-icon");
            dropdown.classList.remove("active");
            autocomplete_list.innerHTML = "";

            // uniq_el = wrapper.parentNode.parentNode.parentNode.parentNode.parentNode;
             uniq_el = wrapper.parentNode.parentNode.closest('div.difl_cptfilter');
            dfMultiFilter.grid_container = uniq_el.querySelector('.df-cpts-wrap');
            dfMultiFilter.selector = uniq_el.querySelector('.df-cpts-inner-wrap');
            dfMultiFilter.ele_class = uniq_el.classList.value.split(" ").filter(function(class_name){
                return class_name.indexOf('difl_cptfilter_') !== -1;
            });
            process_filter_data(uniq_el, dfMultiFilter.grid_container, dfMultiFilter.ele_class[0], '', dfMultiFilter.selector, 'filter', dfMultiFilter.current_column, dfMultiFilter.search_key);
            dfMultiFilter.resetDefaultDropdown();
            e.stopPropagation();
        },
        
        
        // function that returns a list with the autcomplete list of matches
        autocomplete: function(query, options) {
            // No query passed, just return entire list
            if (!query) {
                return options;
            }
            let options_return = {};
        
            for (const [key, value] of Object.entries(options)) {
                if (value.includes(query) || value.toLowerCase().includes(query.toLowerCase())){
                    options_return[key] = value.trim();
                }
            }

            return options_return;
        },
        getOptions: function(select){
            // Select all the options available
            let all_options = {};
            let sorted_options = {};
            Array.from(select.querySelectorAll("option")).forEach(el => {
                all_options[el.value] = el.innerText.trim();
                sorted_options[el.value] = el.innerText.trim();
            });

            // Get the options that are selected from the user
            let options_selected = {};
            Array.from(select.querySelectorAll("option:checked")).forEach(el => {
                options_selected[el.value] = el.innerText.trim();
                delete sorted_options[el.value]
            });
        
            return {all_options: all_options, options_selected: options_selected, sorted_options:sorted_options };
        
        },
        
        // Listener for when the user wants to remove a given token.
        removeToken: function(e) {
            // Get the value to remove
            const value_to_remove = e.target.dataset.option;
            const wrapper = e.target.parentNode.parentNode;
            const input_search = wrapper.querySelector(".selected-input");
            const dropdown = wrapper.querySelector(".dropdown-icon");
            // Get the options in the select to be unselected
            const option_to_unselect = wrapper.querySelector(`select option[value="${value_to_remove}"]`);
            option_to_unselect.removeAttribute("selected");
            // Remove token attribute
            e.target.parentNode.remove();
            input_search.focus();
            dropdown.classList.remove("active");
            const event = new Event('click');
            dropdown.dispatchEvent(event);
            e.stopPropagation();
            const autocomplete_list = wrapper.querySelector(".autocomplete-list");
            //the click was outside the specifiedElement, do something
            dropdown.classList.remove("active");
            autocomplete_list.innerHTML = "";
            // uniq_el = wrapper.parentNode.parentNode.parentNode.parentNode.parentNode;
             uniq_el = wrapper.parentNode.parentNode.closest('div.difl_cptfilter');
            dfMultiFilter.grid_container = uniq_el.querySelector('.df-cpts-wrap');
            dfMultiFilter.selector = uniq_el.querySelector('.df-cpts-inner-wrap');
            dfMultiFilter.ele_class = uniq_el.classList.value.split(" ").filter(function(class_name){
                return class_name.indexOf('difl_cptfilter_') !== -1;
            });
            process_filter_data(uniq_el, dfMultiFilter.grid_container, dfMultiFilter.ele_class[0], '', dfMultiFilter.selector, 'filter', dfMultiFilter.current_column, dfMultiFilter.search_key);
            dfMultiFilter.resetDefaultDropdown();
            dfMultiFilter.remove_selected_element_when_remove_from_field(value_to_remove);
        },
        resetDefaultDropdown: function(){
            const select = document.querySelectorAll("[data-multi-select-plugin]");
            let sub_array = [];
            for (let i = 0; i < select.length; i++) {
                if (event) {
                    let isClickInside = select[i].parentElement.parentElement.contains(event.target);
                
                    sub_array.push($(select[i]).val());
                    
                
                    if (!isClickInside) {
                        const wrapper = select[i].parentElement.parentElement;
                        const dropdown = wrapper.querySelector(".dropdown-icon");
                        const autocomplete_list = wrapper.querySelector(".autocomplete-list");
                        //the click was outside the specifiedElement, do something
                        dropdown.classList.remove("active");
                        autocomplete_list.innerHTML = "";
                        dfMultiFilter.addPlaceholder(wrapper);
                    }
                }
            }
        },
        // Listen for 2 sequence of hits on the delete key, if this happens delete the last token if exist
        deletePressed: function(e) {
            const wrapper = e.target.parentNode.parentNode;
            const input_search = e.target;
            const key = e.keyCode || e.charCode;
            const tokens = wrapper.querySelectorAll(".selected-wrapper");
        
            if (tokens.length) {
                const last_token_x = tokens[tokens.length - 1].querySelector("a");
                let hits = +last_token_x.dataset.hits;
        
                if (key == 8 || key == 46) {
                    if (!input_search.value) {
        
                        if (hits > 1) {
                            // Trigger delete event
                            const event = new Event('click');
                            last_token_x.dispatchEvent(event);
                        } else {
                            last_token_x.dataset.hits = 2;
                        }
                    }
                } else {
                    last_token_x.dataset.hits = 0;
                }
            }
            return true;
        },

        addOption: function(target, val, text) {
            const select = document.querySelector(target);
            let opt = document.createElement('option');
            opt.value = val;
            opt.innerHTML = text;
            select.appendChild(opt);
        },

        generate_filter_selected_elements: function (wrapper, value, label, type) {
            let field_id = '';
            if('select' === type){
                field_id = wrapper.querySelector('select').getAttribute('id');
            }
            if('checkbox' === type){
                field_id = wrapper.parentNode.parentNode.getAttribute('id');
                value = wrapper.getAttribute('data-value');
                label = wrapper.parentNode.innerText;
            }
            const token = document.createElement("div");
            token.classList.add("filter_element_card");
            const token_span = document.createElement("span");
            token_span.classList.add("filter_element_card_text");
            token_span.innerText = label;
            const close = document.createElement("a");
            close.classList.add("filter_element_card_close");
            close.setAttribute("tabindex", "-1");
            close.setAttribute("data-option", value);
            close.setAttribute("data-field", field_id);
            close.setAttribute("data-field_type", type);
            close.setAttribute("data-hits", 0);
            close.setAttribute("href", "javascript:void(0);");
            close.innerText = "x";
            close.addEventListener("click", dfMultiFilter.remove_token_from_selected_filter_elements)
            token.appendChild(token_span);
            token.appendChild(close);
            dfMultiFilter.multi_filter_selected_elements.append(token)
        },
        remove_token_from_selected_filter_elements: function (event) {
            const value_to_remove = event.target.dataset.option;
            const ref_field = event.target.dataset.field;
            const ref_field_type = event.target.dataset.field_type;

            let field = "";
            if('select' === ref_field_type){
                field = dfMultiFilter.multi_filter_acf_selector.querySelector(`.multi_filter_container li .multi-select-component select#${ref_field}`).parentNode.querySelector(`.selected-wrapper a[data-option="${value_to_remove}"]`);
                field.click();
            }
            if('checkbox' === ref_field_type){
                field = dfMultiFilter.multi_filter_acf_selector.querySelector(`.multi_filter_container li .checkbox_container#${ref_field} input[data-value="${value_to_remove}"]`);
                field.parentNode.click();
            }
            event.target.parentNode.remove();
        },
        remove_selected_element_when_remove_from_field: function (value) {
            const element = dfMultiFilter.multi_filter_selected_elements.querySelector(`.filter_element_card a[data-option="${value}"]`);
            element.parentNode.remove();
        }
           
    }
    
    const df_cptfilters = document.querySelectorAll('.difl_cptfilter');
    let df_loader_config = {};

    [].forEach.call(df_cptfilters, function(ele, index){
        let container = ele.querySelector('.df_cptfilter_container');
        let nav = ele.querySelector('.df-cpt-filter-nav');
        let search_input = ele.querySelector('.df_search_filter_input');
        let search_bar_icon = ele.querySelector('.search_bar_button');
        let multiple_filter = ele.querySelectorAll('li.multiple_taxonomy_filter');
        let multiple_filter_acf = ele.querySelectorAll('li.multiple_acf_filter');
        let multiple_filter_ranges = ele.querySelectorAll('.filter_section li .df-rangle-slider');
        let multiple_filter_container = ele.querySelector('.filter_section');
        let grid_container = ele.querySelector('.df-cpts-wrap');
        let selector = ele.querySelector('.df-cpts-inner-wrap');
        let ele_class = ele.classList.value.split(" ").filter(function(class_name){
            return class_name.indexOf('difl_cptfilter_') !== -1;
        });
		let column = df_cpt_filter[ele_class[0]].column;
		let column_tablet = df_cpt_filter[ele_class[0]].column_tablet ? df_cpt_filter[ele_class[0]].column_tablet : column;
		let column_phone = df_cpt_filter[ele_class[0]].column_phone ? df_cpt_filter[ele_class[0]].column_phone : column_tablet;
		
		let current_column = get_column(column, column_tablet, column_phone);
        const total_data = selector.querySelectorAll(`.df-cpts-inner-wrap article`).length;
        total_filter_data[ele_class] = total_data;
        handle_mobile_responsive_filter_container(container);
		window.addEventListener('resize', function(){ 
			current_column = get_column(column, column_tablet, column_phone);
		})
				
        let rowInfo = {
            row : 1,
            top: 0
        };

        if(!grid_container) return;

        const postOrderByInit = parseInt(df_cpt_filter[ele_class[0]].orderby);
        const postOrderByString = ['date', 'date', 'title', 'title', 'random', 'menu_order', 'menu_order' ];
        const postOrderBy = postOrderByString[ postOrderByInit - 1];
        let isOrderAsc = postOrderByInit % 2 === 1;
    
        // on server 'random' has descending order
        if('random' === postOrderBy ){
            isOrderAsc = false;
        }

        // isotope order ascending on number
        if('date' === postOrderBy || 'menu_order' === postOrderBy){
            isOrderAsc = !isOrderAsc;
        }

        const config = {
            layoutMode: df_cpt_filter[ele_class[0]].layout,
            itemSelector: '.df-cpt-item',
            percentPosition: true,
            stagger: 60,
            sortBy: postOrderBy,
            sortAscending: isOrderAsc,
            getSortData: {
                [postOrderBy]: `[data-order] ${'title' !== postOrderBy ? 'parseInt' : ''}`
            }
        }

        if (multiple_filter_ranges){
            multiple_filter_ranges.forEach((multiple_filter_range) => {
                let data = JSON.parse(jQuery(multiple_filter_range).attr('data-range'));
                data.onFinish= function (data) {
                    jQuery(multiple_filter_range).attr('data-range_value',JSON.stringify([data.from, data.to]));
                    process_filter_data(ele, grid_container, ele_class[0], '', selector, 'filter', current_column, '' !== search_input ? search_input: '');
                };
                jQuery(multiple_filter_range).ionRangeSlider(data);
            })
        }

        // init Isotope
        let iso = new Isotope(selector, config);

        // fix the lazy load layout issue
        let entries = selector.querySelectorAll('.df-cpt-item');
        observer = new IntersectionObserver(function (item) {
            iso.layout();
        });
        
        [].forEach.call(entries, function (v){
            observer.observe( v );
        });      
        // *****************

        setTimeout(function(){
            iso.layout();
            grid_container.parentNode.classList.add('load-complete');
        }, 500);

		if( df_cpt_filter[ele_class[0]].equal_height === 'on' ) {
			document.addEventListener( "DOMContentLoaded", function() {
				calRowClass( selector, selector.querySelectorAll('.df-cpt-item'), current_column );
			} )
		}
		
		window.addEventListener('resize', function(){
			calRowClass( selector, selector.querySelectorAll('.df-cpt-item'), current_column );
		})
        
        // filter buttons on click
        if(nav){
            nav.addEventListener('click', function(e){
                if(e.target.nodeName === 'LI') {
                    let term_id = e.target.dataset.term;
                    if(!e.target.classList.contains('df-active')) {
                        df_filter_btn_active_state(nav, e.target);                  
                        const search_key = null !== search_input ? search_input.value: '' ;
                        iso.remove(iso.getItemElements()); // remove previous data or items will be double which will create blank spaces beteween visible items & wrong ordering
                        const selected_data = {"taxonomy":df_cpt_filter[ele_class[0]].selected_tax, "acf":[]};
                        fetch_request( grid_container, ele_class[0], term_id, selector, selected_data, 'filter', current_column , search_key );
                    } 
                }
            })
        }
        
        if(search_input && search_bar_icon){
            // search click
            search_bar_icon.addEventListener('click' , function(e){
                if(e.isTrusted && search_input.value === ''){
                    return;
                }
                // disable click for 1sec
                const clickSpan = $('.search_bar_button')
                clickSpan.css('pointer-events', 'none')
                setTimeout(() => {
                    clickSpan.css('pointer-events', 'auto')
                }, 1000)

                let term_id = '';
                if(nav){
                    const  activeList = e.target.parentNode.parentNode.parentNode.querySelector('.df-cpt-filter-nav li.df-active');
                     term_id = activeList && activeList.dataset.term ? activeList.dataset.term : '' ;
                }else{
                    term_id = '';
                }          
                const multi_filter_selector = e.target.parentNode.parentNode.querySelectorAll('li.multiple_taxonomy_filter');
                let multiple_filter_data = {}, multiple_filter_select_data = {}, multiple_filter_checkbox_data = {};
                if(jQuery(multi_filter_selector).find('select')){
                    multiple_filter_select_data = jQuery(multi_filter_selector).find('select').map(function() {
                        let selected = [...this.options]
                            .filter(option => option.selected && option.value !== 'all')
                            .map(option => option.value);

                        return {term_id : selected, texonomy_name: this.name, field_type: 'select'};

                    }).get();
                }
                if(jQuery(multi_filter_selector).find("input[type='checkbox']:checked")){
                    multiple_filter_checkbox_data = jQuery(multi_filter_selector)
                        .find("input[type='checkbox']:checked")
                        .map(function () {
                            const parentId = jQuery(this).closest('[id]').attr('id');
                            return { term_id: jQuery(this).attr('data-value'), texonomy_name: parentId };
                        })
                        .get()
                        .reduce(function (accumulator, currentValue) {
                            const texonomy_name = currentValue.texonomy_name;

                            const existingEntry = accumulator.find(entry => entry.texonomy_name === texonomy_name);

                            if (existingEntry) {
                                existingEntry.term_id.push(currentValue.term_id);
                            } else {
                                accumulator.push({
                                    texonomy_name: texonomy_name,
                                    term_id: [currentValue.term_id],
                                    field_type: 'checkbox'
                                });
                            }
                            return accumulator;
                        }, []);
                }

                multiple_filter_data = [...multiple_filter_select_data, ...multiple_filter_checkbox_data];


                // ACF Filter
                let multiple_filter_acf_data = {}, multiple_filter_select_acf_data = {},
                    multiple_filter_checkbox_acf_data = {}, multiple_filter_range_acf_data = {};
                const multi_filter_acf_selector = e.target.parentNode.parentNode.querySelectorAll('li.multiple_acf_filter');
                if(multi_filter_acf_selector){
                    if(jQuery(multi_filter_acf_selector).find('select')){
                        multiple_filter_select_acf_data = jQuery(multi_filter_acf_selector).find('select').map(function() {
                            const selected = [...this.options]
                                .filter(option => option.selected && option.value !== 'all')
                                .map(option => option.value);
                            return {acf_value : selected, acf_name: this.name, field_type: 'select'};
                        }).get();
                    }
                    if(jQuery(multi_filter_acf_selector).find("input[type='checkbox']:checked")){
                        multiple_filter_checkbox_acf_data = jQuery(multi_filter_acf_selector)
                            .find("input[type='checkbox']:checked")
                            .map(function () {
                                const parentId = jQuery(this).closest('[id]').attr('id');
                                return { acf_value: jQuery(this).attr('data-value'), acf_name: parentId };
                            })
                            .get()
                            .reduce(function (accumulator, currentValue) {
                                const acfName = currentValue.acf_name;

                                const existingEntry = accumulator.find(entry => entry.acf_name === acfName);

                                if (existingEntry) {
                                    existingEntry.acf_value.push(currentValue.acf_value);
                                } else {
                                    accumulator.push({
                                        acf_name: acfName,
                                        acf_value: [currentValue.acf_value],
                                        field_type: 'checkbox'
                                    });
                                }
                                return accumulator;
                            }, []);
                    }
                    if(jQuery(multi_filter_acf_selector).find("input[type='text']")){
                        multiple_filter_range_acf_data = jQuery(multi_filter_acf_selector)
                            .find("input[type='text']")
                            .map(function () {
                                const range_value_checker = JSON.parse(jQuery(this).attr('data-range'));
                                const range_value = JSON.parse(jQuery(this).attr('data-range_value'));
                                if(range_value[0] > range_value_checker.min || range_value[1] < range_value_checker.max ){
                                    return { acf_value: range_value, acf_name: jQuery(this).attr('data-value'), field_type: 'range' };
                                }
                            });
                    }
                    multiple_filter_acf_data = [...multiple_filter_select_acf_data, ...multiple_filter_checkbox_acf_data, ...multiple_filter_range_acf_data];

                }
                // ACF Filter
                const selected_data = nav ? {"taxonomy":df_cpt_filter[ele_class[0]].selected_tax, "acf":multiple_filter_acf_data} : {"taxonomy":multiple_filter_data, "acf":multiple_filter_acf_data};
                const search_input_value = search_input.value;
                if(search_input_value.length > 0) { 
                    iso.remove(iso.getItemElements()); // reset previous data to prevent blank spaces beteween visible items
                    fetch_request( grid_container, ele_class[0], term_id , selector, selected_data , 'filter', current_column , search_input_value);
                } else{
                    iso.remove(iso.getItemElements()); // reset previous data to prevent blank spaces beteween visible items
                    fetch_request( grid_container, ele_class[0], term_id , selector, selected_data , 'filter', current_column);
                }

            })

            search_input.addEventListener('keypress', function(event){
                if (event.key === "Enter" &&  '' !== event.target.value) {
                    event.preventDefault();
                    search_bar_icon.click();
                }
                            
            })
            search_input.addEventListener('keyup', function(ev){
                  if(ev.target.value === '' && ev.key !== "Enter"){
                    ev.preventDefault();
                    search_bar_icon.click();
                  }
            })
        }
        // load more button on click
        grid_container.addEventListener('click', function(e) {
            if(e.target.className === "df-cptfilter-load-more") {
                e.preventDefault();
                if('multiple_filter' === df_cpt_filter[ele_class[0]].post_display){
                    const uniq_el = e.target.parentNode.parentNode.parentNode.closest('div.difl_cptfilter');
                    process_filter_data(uniq_el, grid_container, ele_class[0], '', selector, 'loadmore', current_column, search_input);
                }else{
                    let term_id = e.target.dataset.term;
                    let texonomy_list = term_id !=='' ? df_cpt_filter[ele_class[0]].selected_tax : e.target.dataset.multiple_texonomy; // Check multi texonomy filter or normar filter
                    const selected_data = {"taxonomy":texonomy_list, "acf":[]};
                    fetch_request( grid_container, ele_class[0], term_id, selector, selected_data, 'loadmore', current_column );
                }

            }
        })
     
        let items = [];

        document.addEventListener("DOMContentLoaded", () => {

            // get select that has the options available
            const select1 = container.querySelectorAll("[data-multi-select-plugin]");
            select1.forEach(select => {
                dfMultiFilter.init(select , ele , current_column ,search_input);
            });

            // Dismiss on outside click
            document.addEventListener('click', () => {
                // get select that has the options available
                const select = document.querySelectorAll("[data-multi-select-plugin]");

                if(select){
                    dfMultiFilter.resetDefaultDropdown();
                }
            
            });

        });
  
    })

    function handle_mobile_responsive_filter_container(container) {
        if (window.innerWidth <= 767) {
            $(container).on("click", function (e) {
                const target = $(e.target);
                let parent_class = "";
                if (target.hasClass("df_phn_resp")) {
                    target.removeClass("df_phn_resp")
                        .addClass("df_phn_resp_cls")
                    $('html, body').animate({
                        scrollTop: target.offset().top - 10
                    }, 1500);
                    document.body.classList.add('difl-cpt-stop-scrolling');
                    const classList = e.target.parentNode.closest('.difl_cptfilter').classList;
                    parent_class = classList[classList.length - 1];
                    const filter_short_desc = document.createElement("div");
                    filter_short_desc.classList.add("difl_filter_short_desc_card");
                    filter_short_desc.setAttribute("data-parent", parent_class);

                    const filter_short_desc_title = document.createElement('h4');
                    filter_short_desc_title.innerText = "Filter"
                    let filter_short_desc_header = e.target.querySelector('.difl_filter_short_desc_card_header');
                    if(!filter_short_desc_header){
                        filter_short_desc_header = document.createElement('div');
                        filter_short_desc_header.classList.add("difl_filter_short_desc_card_header");
                        filter_short_desc_header.appendChild(filter_short_desc_title);
                        filter_short_desc_header.appendChild(e.target.querySelector('.filter_elements'));
                    }else{
                        filter_short_desc_header.insertBefore(filter_short_desc_title, filter_short_desc_header.firstChild);
                    }
                    const show_btn = document.createElement("a");
                    show_btn.classList.add("difl_filter_show_btn");
                    show_btn.innerText = `Show (${total_filter_data[parent_class]})`;
                    show_btn.setAttribute("href", "javascript:void(0);");
                    show_btn.addEventListener("click", hide_mobile_resp_filter_from_short_desp)

                    const cls_btn = document.createElement("a");
                    cls_btn.classList.add("difl_filter_cls_btn");
                    cls_btn.innerText = "Cancel";
                    cls_btn.addEventListener("click", hide_mobile_resp_filter_from_short_desp)

                    filter_short_desc.appendChild(show_btn);
                    filter_short_desc.appendChild(cls_btn);
                    e.target.querySelector('.filter_wrapper').append(filter_short_desc);
                    e.target.querySelector('.filter_wrapper').insertBefore(filter_short_desc_header, e.target.querySelector('.filter_wrapper').firstChild);
                }else if (target.hasClass("df_phn_resp_cls")) {
                    target.removeClass("df_phn_resp_cls")
                        .addClass("df_phn_resp")
                    document.body.classList.remove('difl-cpt-stop-scrolling');
                    e.target.querySelector(`.filter_wrapper .difl_filter_short_desc_card_header h4`).remove();
                    e.target.querySelector(`.filter_wrapper .difl_filter_short_desc_card`).remove();
                }

            });

        }
    }
    function hide_mobile_resp_filter_from_short_desp(event) {
        const parent_class = event.target.parentNode.getAttribute("data-parent");
        const target = $(event.target);
        if (target.hasClass("difl_filter_cls_btn")) {
            let filter_elements_container = document.querySelectorAll(`.${parent_class} .df_cptfilter_container .filter_section .filter_elements .filter_element_card a`);
            [].forEach.call(filter_elements_container, function(element, index){
                element.click();
            });
        }
        let container = document.querySelector(`.${parent_class} .df_cptfilter_container .filter_section`);
        container.click();
        if(document.querySelector(`.difl_filter_short_desc_card[data-parent="${parent_class}"]`)){
            document.querySelector(`.difl_filter_short_desc_card[data-parent="${parent_class}"]`).remove();
        }
    }



    function process_filter_data(uniq_el, grid_container, ele_class, term_id, selector, data_type, current_column, search_key){
        multi_filter_selector = uniq_el.querySelectorAll('li.multiple_taxonomy_filter');
        let multiple_filter_data = {}, multiple_filter_select_data = {}, multiple_filter_checkbox_data = {};
        if(jQuery(multi_filter_selector).find('select')){
            multiple_filter_select_data = jQuery(multi_filter_selector).find('select').map(function() {
                let selected = [...this.options]
                    .filter(option => option.selected && option.value !== 'all')
                    .map(option => option.value);

                return {term_id : selected, texonomy_name: this.name, field_type: 'select'};

            }).get();
        }
        if(jQuery(multi_filter_selector).find("input[type='checkbox']:checked")){
            multiple_filter_checkbox_data = jQuery(multi_filter_selector)
                .find("input[type='checkbox']:checked")
                .map(function () {
                    const parentId = jQuery(this).closest('[id]').attr('id');
                    return { term_id: jQuery(this).attr('data-value'), texonomy_name: parentId };
                })
                .get()
                .reduce(function (accumulator, currentValue) {
                    const texonomy_name = currentValue.texonomy_name;

                    const existingEntry = accumulator.find(entry => entry.texonomy_name === texonomy_name);

                    if (existingEntry) {
                        existingEntry.term_id.push(currentValue.term_id);
                    } else {
                        accumulator.push({
                            texonomy_name: texonomy_name,
                            term_id: [currentValue.term_id],
                            field_type: 'checkbox'
                        });
                    }
                    return accumulator;
                }, []);
        }

        multiple_filter_data = [...multiple_filter_select_data, ...multiple_filter_checkbox_data];
        // ACF Filter
        let multiple_filter_acf_data = {}, multiple_filter_select_acf_data = {},
            multiple_filter_checkbox_acf_data = {}, multiple_filter_range_acf_data = {};
        multi_filter_selector = uniq_el.querySelectorAll('li.multiple_acf_filter');
        if(multi_filter_selector){
            if(jQuery(multi_filter_selector).find('select')){
                multiple_filter_select_acf_data = jQuery(multi_filter_selector).find('select').map(function() {
                    const selected = [...this.options]
                        .filter(option => option.selected && option.value !== 'all')
                        .map(option => option.value);
                    return {acf_value : selected, acf_name: this.name, field_type: 'select'};
                }).get();
            }
            if(jQuery(multi_filter_selector).find("input[type='checkbox']:checked")){
                multiple_filter_checkbox_acf_data = jQuery(multi_filter_selector)
                    .find("input[type='checkbox']:checked")
                    .map(function () {
                        const parentId = jQuery(this).closest('[id]').attr('id');
                        return { acf_value: jQuery(this).attr('data-value'), acf_name: parentId };
                    })
                    .get()
                    .reduce(function (accumulator, currentValue) {
                        const acfName = currentValue.acf_name;

                        const existingEntry = accumulator.find(entry => entry.acf_name === acfName);

                        if (existingEntry) {
                            existingEntry.acf_value.push(currentValue.acf_value);
                        } else {
                            accumulator.push({
                                acf_name: acfName,
                                acf_value: [currentValue.acf_value],
                                field_type: 'checkbox'
                            });
                        }
                        return accumulator;
                    }, []);
            }
            if(jQuery(multi_filter_selector).find("input[type='text']")){
                multiple_filter_range_acf_data = jQuery(multi_filter_selector)
                    .find("input[type='text']")
                    .map(function () {
                        const range_value_checker = JSON.parse(jQuery(this).attr('data-range'));
                        const range_value = JSON.parse(jQuery(this).attr('data-range_value'));
                        if(range_value[0] > range_value_checker.min || range_value[1] < range_value_checker.max ){
                            return { acf_value: range_value, acf_name: jQuery(this).attr('data-value'), field_type: 'range' };
                        }
                    });
            }
            multiple_filter_acf_data = [...multiple_filter_select_acf_data, ...multiple_filter_checkbox_acf_data, ...multiple_filter_range_acf_data];

        }
        // ACF Filter
        const searchValue = null !== search_key  ? search_key.value : '';
        const selected_data = {"taxonomy":multiple_filter_data, "acf":multiple_filter_acf_data};
        fetch_request( grid_container, ele_class, '', selector, selected_data , data_type, current_column, searchValue );
    }

    /**
     * Make fetch request and pull data 
     * by post type slug
     * 
     * @param {String} grid_container
     * @param {String} ele_class
     * @param {INT} term_id
     * @param {Object} selector
     * @param {String} _request | loadmore or filter 
     */
    function fetch_request( grid_container, ele_class, term_id, selector, selected_tax, _request = 'loadmore', current_column , search_value = '' ) {
        let load_more = df_cpt_filter[ele_class].load_more;
        let ajaxurl = window.et_pb_custom.ajaxurl;
        let load_more_btn = grid_container.querySelector('.df-cptfilter-load-more');
        let load_more_btn_container = grid_container.querySelector('.load-more-pagintaion-container');
        let page = _request === 'filter' ? 1 : load_more_btn.dataset.current;
        let iso = Isotope.data(selector);

        // showing loading
        function displayLoading() {
            if(!df_cpt_filter_loader.loader_exist('df_cpt_filter', grid_container)){
                df_cpt_filter_loader.load({
                    type: df_cpt_filter[ele_class].loader.type,
                    name: 'df_cpt_filter',
                    color: df_cpt_filter[ele_class].loader.color,
                    background: df_cpt_filter[ele_class].loader.background,
                    size: df_cpt_filter[ele_class].loader.size,
                    margin:[df_cpt_filter[ele_class].loader.margin[0],df_cpt_filter[ele_class].loader.margin[1],df_cpt_filter[ele_class].loader.margin[2],df_cpt_filter[ele_class].loader.margin[3]],
                    alignment: df_cpt_filter[ele_class].loader.alignment,
                    container: grid_container,
                    position: 'absolute',
                    z_index: 999999,
                    margin_from_top: df_cpt_filter[ele_class].loader.margin_from_top
                });
            }
        }
        
        // hiding loading 
        function hideLoading() {
            if(df_cpt_filter_loader.loader_exist('df_cpt_filter', grid_container)) df_cpt_filter_loader.remove_loader('df_cpt_filter', grid_container);
        }
        grid_container.parentNode.classList.add('df-filter-loading');
        grid_container.parentNode.classList.remove('load-complete');
        if(df_cpt_filter[ele_class].loader_spining === 'on'){
            displayLoading();
        }
        // selected_tax = JSON.parse(selected_tax);
        let sarch_key = search_value;
        fetch(ajaxurl, {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'Cache-Control': 'no-cache',
            },
            body: new URLSearchParams({
                et_frontend_nonce: window.et_pb_custom.et_frontend_nonce,
                action: 'df_cpt_filter_data',
                term_id: term_id,
                post_type: df_cpt_filter[ele_class].post_type,
                post_display: df_cpt_filter[ele_class].post_display,
                posts_number: df_cpt_filter[ele_class].posts_number,
                offset_number: df_cpt_filter[ele_class].offset_number,
                equal_height: df_cpt_filter[ele_class].equal_height,
                use_image_as_background: df_cpt_filter[ele_class].use_image_as_background,
                use_background_scale: df_cpt_filter[ele_class].use_background_scale,
                use_number_pagination: df_cpt_filter[ele_class].use_number_pagination,
                show_pagination: df_cpt_filter[ele_class].show_pagination,
                older_text: df_cpt_filter[ele_class].older_text,
                newer_text: df_cpt_filter[ele_class].newer_text,
                cpt_item_inner: df_cpt_filter[ele_class].cpt_item_inner,
                cpt_item_outer: df_cpt_filter[ele_class].cpt_item_outer,
                load_more: load_more,
                use_load_more_icon: df_cpt_filter[ele_class].use_load_more_icon,
                load_more_font_icon: df_cpt_filter[ele_class].load_more_font_icon,
                load_more_icon_pos: df_cpt_filter[ele_class].load_more_icon_pos,
                use_load_more_text: df_cpt_filter[ele_class].use_load_more_text,
                use_empty_post_message: df_cpt_filter[ele_class].use_empty_post_message,
                empty_post_message: df_cpt_filter[ele_class].empty_post_message,   
                all_items: df_cpt_filter[ele_class].all_items,
                current_page: page,
                selected_tax: JSON.stringify(selected_tax.taxonomy),
                selected_acf: JSON.stringify(selected_tax.acf),
                multi_filter_type: df_cpt_filter[ele_class].multi_filter_type,
                search_value: sarch_key,
                _request: _request,
                orderby: df_cpt_filter[ele_class].orderby,
                enable_acf_filter: df_cpt_filter[ele_class].enable_acf_filter,
                entire_item_clickable: df_cpt_filter[ele_class].entire_item_clickable,
            })
        })
        .then(function(response){ 
            if(_request === 'filter') {
                iso.remove(iso.getItemElements())
                iso.reloadItems()
            }
            return response.json()
         })
        .then(function(response){
            let parser = new DOMParser();
            let parsedHtml = parser.parseFromString(response.data, 'text/html');
            let items = parsedHtml.querySelectorAll('.df-cpt-item');
                   
            let update_load_more = parsedHtml.querySelector('.load-more-pagintaion-container');
            iso = Isotope.data(selector);

            if(_request === 'filter') {

                if( grid_container.querySelector('.no-post') ) {
                    const noPost = grid_container.querySelector('.no-post');
                    grid_container.removeChild(noPost);

                    grid_container.classList.remove('no-post-container');
                }
                if(items.length > 0){
                
                    items.forEach(function(item){
                        selector.appendChild(item);

                    })

                }else{
                    const noPost = parsedHtml.querySelector('.no-post');
                    grid_container.appendChild(noPost);
                    grid_container.classList.add('no-post-container');
                    
                }
        
             
                if(load_more_btn_container) {
                    load_more_btn_container.remove();
                }
                if(update_load_more) {

                    grid_container.appendChild(update_load_more);
                    let loadMoreButton = grid_container.querySelector('.load-more-pagintaion-container a.df-cptfilter-load-more');
                    loadMoreButton.setAttribute('data-multiple_texonomy' , selected_tax.taxonomy );

                }
                // settings the css valiable to default
                iso.remove(iso.getItemElements());
            } else {
                items.forEach(function(item){
                    selector.appendChild(item);
                })
                load_more_btn.setAttribute("data-current", (parseInt(page)+1))

                if( parseInt(load_more_btn.dataset.current) >= parseInt(load_more_btn.dataset.pages) ) {
                    load_more_btn.style.display="none";
                }
                load_more_btn.style.opacity = '1';
                load_more_btn.style.pointerEvents = 'all';

            }

            // data is processed and new item added to container.
            iso.appended(items)
            return items;
        })
        .then(function( items ) {
            // refresing the layout in case the layout not positions properly.
            iso = Isotope.data( selector );
            
            if( df_cpt_filter[ele_class].equal_height === 'on' && _request === 'loadmore' ) {
                setTimeout( function(){
                    calRowClass( selector, selector.querySelectorAll('.df-cpt-item'), current_column );
                }, 50 );
                setTimeout( function(){
                    iso.layout();
                }, 100 );
                // Filter short description data
                total_filter_data[ele_class] = total_filter_data[ele_class] + items.length

            } else if( df_cpt_filter[ele_class].equal_height === 'on' && _request === 'filter' ) {
                setTimeout(function () {
                    calRowClass(selector, items, current_column);
                }, 50);
                setTimeout( function(){
                    iso.layout();
                }, 100 );
                // Filter short description data
                total_filter_data[ele_class] = items.length
            } else {
                setTimeout( function(){
                    if(_request === 'filter') {
                        iso.arrange();
                    }
                    iso.updateSortData(items);
                    iso.layout();
                }, 100 );
                // Filter short description data
                total_filter_data[ele_class] = items.length
            }

            // loading is completed
            grid_container.parentNode.classList.remove( 'df-filter-loading' );
            grid_container.parentNode.classList.add( 'load-complete' );
            if(df_cpt_filter[ele_class].loader_spining === 'on'){
                hideLoading();
            }

            // Filter short description data
            if(document.querySelector(`.difl_filter_short_desc_card[data-parent="${ele_class}"]`)){
                const difl_filter_short_desc_card = document.querySelector(`.difl_filter_short_desc_card[data-parent="${ele_class}"]`);
                difl_filter_short_desc_card.querySelector('.difl_filter_show_btn').innerText = `Show (${total_filter_data[ele_class]})`;
            }


        }) 
    }
	
	/**
	 * Get column by device and window width
	 * 
	 * 
	 */
	 function get_column(column, column_tablet, column_phone) {
		 let current = column;
		 
		 if (window.innerWidth <= 767 ) {
			 current = column_phone;
		 } else if (window.innerWidth <= 980) {
			 current = column_tablet;
		 }
		 		 
		 return current;
	 }

    /**
     * Change the active nav button
     * on click event
     * 
     * @param {Object} nav_container | Filter nav container
     * @param {Object} nav_item | Selected nav item 
     */
    function df_filter_btn_active_state(nav_container, nav_item) {
        let nav_items = nav_container.querySelectorAll('.df-cpt-filter-nav-item');
        [].map.call(nav_items, function(nav_item) {
            nav_item.classList.remove('df-active');
        })
        nav_item.classList.add('df-active');
    }
	
	/**
     * Calculate the row class and
     * apply row height to each element.
     * 
     * @param Selector
     * @param elements
     * @param column
     */
	function calRowClass( selector, elements, column ) {
		
		let row = 1;
		let count = 1;
		let rowArray = [];
		
		[].forEach.call( elements, function( element ) {
			row = Math.ceil(count / column);
			
			let exis = element.classList.value.split(" ").filter(function(class_name){
				return class_name.indexOf('cpt-item-row-') !== -1;
			});
			if( exis.length !== 0 ) {
				element.classList.remove(exis)
			}
			
			element.classList.add( 'cpt-item-row-' + row );
						
			if (!rowArray.includes(row)) {
    			rowArray.push(row);
			}
			count++;
		})
				
		for( let i = 0; i < rowArray.length; i++ ) {
            rowHeight( selector, 'cpt-item-row-' + rowArray[i], elements );
        }
        row = 1;
		rowArray = [];	
	}

    /**
     * Apply equal height to elements
     * 
     */
    function equalHeight( selector, elements, rowInfo ) {
        let row = rowInfo.row;
        let top = 0;
        [].forEach.call( elements, function( element ) {
            
            let style = getComputedStyle( element );
            let itemTop = parseInt( style.getPropertyValue( 'top' ) );

            if( itemTop == top ) {
                element.classList.add( 'cpt-item-row-' + row );
            } else {
                top = itemTop;
                row++;
                element.classList.add( 'cpt-item-row-' + row );
            }

        } )

        for( let i = rowInfo.row; i <= row; i++ ) {
            rowHeight( selector, 'cpt-item-row-' + i );
        }
        rowInfo.row = row;
        rowInfo.top = top;
    }
    
    /**
     * Get the row max-height and
     * apply to each row item
     * 
     */
    function rowHeight( selector, rowClass, elements ) {		
		let rowElements = [...elements].filter(element => element.classList.contains(rowClass));
				
        let height = [];

        [].forEach.call( rowElements, function( rowElement ) {
            let style = getComputedStyle( rowElement );
            let rowElementHeight = parseInt( style.getPropertyValue( 'height' ) );
            height.push( rowElementHeight );
        } );
		
        $( selector ).find( `.${rowClass}` ).css( 'min-height', Math.max(...height) );
    }
})( jQuery )

const df_cpt_filter_loader = {
    options: {
        type: 'spinner_1',
        name: '',
        color: '#000000',
        background: '#ADD8E6',
        size: '10px',
        margin: ['0px', '0px', '0px', '0px'],
        alignment: 'center',
        container: null,
        position: 'relative',
        z_index: '',
        margin_from_top: '',
    },
    __init__: function (user_data) {
        for (let prop in user_data) {
            if (Object.prototype.hasOwnProperty.call(user_data, prop)) {
                if (user_data[prop] !== undefined && user_data[prop] !== null && user_data[prop] !== '') {
                    this.options[prop] = user_data[prop];
                }
            }
        }
    },
    __render__loader: function () {
        const container = this.__generate__loader_container();
        container.appendChild(this.__generate__loader_style());
        container.appendChild(this.__generate__loader_content());
        this.options.container.appendChild(container);
    },
    __generate__loader_container: function () {
        const loader = document.createElement('div');
        if (1 === this.options.margin.length) loader.style.margin = this.options.margin[0].length > 0 ? this.options.margin[0] : '0px';
        if (2 === this.options.margin.length) loader.style.margin = `${this.options.margin[0].length > 0 ? this.options.margin[0] : '0px'} ${this.options.margin[1] && this.options.margin[1].length > 0 ? this.options.margin[1] : '0px'}`;
        if (4 === this.options.margin.length) loader.style.margin = `${this.options.margin[0].length > 0 ? this.options.margin[0] : '0px'} ${this.options.margin[1] && this.options.margin[1].length > 0 ? this.options.margin[1] : '0px'} ${this.options.margin[2] && this.options.margin[2].length > 0 ? this.options.margin[2] : '0px'} ${this.options.margin[3] && this.options.margin[3].length > 0 ? this.options.margin[3] : '0px'}`;

        loader.style.width = '100%';
        loader.style.display = 'flex';
        if ('left' === this.options.alignment) loader.style.justifyContent = 'flex-start';
        if ('center' === this.options.alignment) loader.style.justifyContent = 'center';
        if ('right' === this.options.alignment) loader.style.justifyContent = 'flex-end';
        loader.style.position = this.options.position;
        loader.style.top = this.options.margin_from_top;
        loader.style.left = '0px';
        loader.style.right = '0px';
        loader.style.zIndex = this.options.z_index;
        loader.classList.add(`${this.options.name}--loader`);

        return loader;
    },
    __generate__loader_style: function () {
        const styles = {
            classic: `
            .${this.options.name}-${this.options.type} {
              width: fit-content;
              font-weight: bold;
              font-family: monospace;
              font-size: ${this.options.size};
              color: ${this.options.color};
            }
            .${this.options.name}-${this.options.type}:before {
              content:"Loading...";
              clip-path: inset(0 3ch 0 0);
              animation: ${this.options.name}-anim 1s steps(4) infinite;
            }
            @keyframes ${this.options.name}-anim {to{clip-path: inset(0 -1ch 0 0)}}
            `,
            dot_1: `
            .${this.options.name}-${this.options.type} {
              width: ${this.options.size};
              aspect-ratio: 4;
              --_g: no-repeat radial-gradient(circle closest-side,${this.options.color} 90%,transparent);
              background: 
                var(--_g) 0%   50%,
                var(--_g) 50%  50%,
                var(--_g) 100% 50%;
              background-size: calc(100%/3) 100%;
              animation: ${this.options.name}-anim 1s infinite linear;
            }
            @keyframes ${this.options.name}-anim {
                33%{background-size:calc(100%/3) 0%  ,calc(100%/3) 100%,calc(100%/3) 100%}
                50%{background-size:calc(100%/3) 100%,calc(100%/3) 0%  ,calc(100%/3) 100%}
                66%{background-size:calc(100%/3) 100%,calc(100%/3) 100%,calc(100%/3) 0%  }
            }
            `,
            dot_2: `
            .${this.options.name}-${this.options.type} {
              width: ${this.options.size};
              margin-right:5px;
              aspect-ratio: 1;
              border-radius: 50%;
              animation: ${this.options.name}-anim 1s infinite linear alternate;
            }
            @keyframes ${this.options.name}-anim {
                0%   {box-shadow: ${parseInt(this.options.size.replace(/[^0-9]/g, '')) + 5}px 0 ${this.hex2rgba(this.options.color, 1)}, -${parseInt(this.options.size.replace(/[^0-9]/g, '')) + 5}px 0 ${this.hex2rgba(this.options.color, 0.2)}; background: ${this.hex2rgba(this.options.color, 1)}}
                33%  {box-shadow: ${parseInt(this.options.size.replace(/[^0-9]/g, '')) + 5}px 0 ${this.hex2rgba(this.options.color, 1)}, -${parseInt(this.options.size.replace(/[^0-9]/g, '')) + 5}px 0 ${this.hex2rgba(this.options.color, 0.2)}; background: ${this.hex2rgba(this.options.color, 0.2)}}
                66%  {box-shadow: ${parseInt(this.options.size.replace(/[^0-9]/g, '')) + 5}px 0 ${this.hex2rgba(this.options.color, 0.2)}, -${parseInt(this.options.size.replace(/[^0-9]/g, '')) + 5}px 0 ${this.hex2rgba(this.options.color, 1)}; background: ${this.hex2rgba(this.options.color, 0.2)}}
                100% {box-shadow: ${parseInt(this.options.size.replace(/[^0-9]/g, '')) + 5}px 0 ${this.hex2rgba(this.options.color, 0.2)}, -${parseInt(this.options.size.replace(/[^0-9]/g, '')) + 5}px 0 ${this.hex2rgba(this.options.color, 1)}; background: ${this.hex2rgba(this.options.color, 1)}}
            }
            `,
            bar_1: `
            .${this.options.name}-${this.options.type} {
              width: ${this.options.size};
              aspect-ratio: .75;
              --c: no-repeat linear-gradient(${this.options.color} 0 0);
              background: 
                var(--c) 0%   50%,
                var(--c) 50%  50%,
                var(--c) 100% 50%;
              animation: ${this.options.name}-anim 1s infinite linear alternate;
            }
            @keyframes ${this.options.name}-anim {
              0%  {background-size: 20% 50% ,20% 50% ,20% 50% }
              20% {background-size: 20% 20% ,20% 50% ,20% 50% }
              40% {background-size: 20% 100%,20% 20% ,20% 50% }
              60% {background-size: 20% 50% ,20% 100%,20% 20% }
              80% {background-size: 20% 50% ,20% 50% ,20% 100%}
              100%{background-size: 20% 50% ,20% 50% ,20% 50% }
            }
            `,
            bar_2: `
            .${this.options.name}-${this.options.type} {
              width: ${this.options.size};
              aspect-ratio: 1;
              background: 
                linear-gradient(transparent calc(1*100%/6),${this.options.color} 0 calc(3*100%/6),transparent 0) left   bottom,
                linear-gradient(transparent calc(2*100%/6),${this.options.color} 0 calc(4*100%/6),transparent 0) center bottom,
                linear-gradient(transparent calc(3*100%/6),${this.options.color} 0 calc(5*100%/6),transparent 0) right  bottom;
              background-size: 20% 600%;
              background-repeat: no-repeat;
              animation: ${this.options.name}-anim 1s infinite linear;
            }
            @keyframes ${this.options.name}-anim {
              100% {background-position: left top,center top,right top }
            }
            `,
            spinner_1: `
            .${this.options.name}-${this.options.type} {
              width: ${this.options.size};
              aspect-ratio: 1;
              border-radius: 50%;
              border: 8px solid ${this.options.background};
              border-right-color: ${this.options.color};
              animation: ${this.options.name}-anim 1s infinite linear;
            }
            @keyframes ${this.options.name}-anim {
              to{transform: rotate(1turn)}}
            }
            `,
            spinner_2: `
            .${this.options.name}-${this.options.type} {
              width: ${this.options.size};
              padding: 8px;
              aspect-ratio: 1;
              border-radius: 50%;
              background: ${this.options.color};
              --_m: 
                conic-gradient(#0000 10%,#000),
                linear-gradient(#000 0 0) content-box;
              -webkit-mask: var(--_m);
                      mask: var(--_m);
              -webkit-mask-composite: source-out;
                      mask-composite: subtract;
              animation: ${this.options.name}-anim 1s infinite linear;
            }
            @keyframes ${this.options.name}-anim {
              to{transform: rotate(1turn)}
            }
            `,
            spinner_3: `
            .${this.options.name}-${this.options.type} {
              width: ${this.options.size};
              aspect-ratio: 1;
              border-radius: 50%;
              background: 
                radial-gradient(farthest-side,${this.options.color} 94%,#0000) top/8px 8px no-repeat,
                conic-gradient(#0000 30%,${this.options.color});
              -webkit-mask: radial-gradient(farthest-side,#0000 calc(100% - 8px),#000 0);
              animation: ${this.options.name}-anim 1s infinite linear;
            }
            @keyframes ${this.options.name}-anim {
              100%{transform: rotate(1turn)}
            }
            `,
            spinner_4: `
            .${this.options.name}-${this.options.type} {
              width: ${this.options.size};
              aspect-ratio: 1;
              border-radius: 50%;
              padding: 6px;
              background:
                conic-gradient(from 135deg at top,${this.options.color} 90deg, #0000 0) 0 calc(50% - 4px)/17px 8.5px,
                radial-gradient(farthest-side at bottom left,#0000 calc(100% - 6px),${this.options.color} calc(100% - 5px) 99%,#0000) top right/50%  50% content-box content-box,
                radial-gradient(farthest-side at top        ,#0000 calc(100% - 6px),${this.options.color} calc(100% - 5px) 99%,#0000) bottom   /100% 50% content-box content-box;
              background-repeat: no-repeat;
              animation: ${this.options.name}-anim 1s infinite linear;
            }
            @keyframes ${this.options.name}-anim {
              100%{transform: rotate(1turn)}
            }
            `,
            spinner_5: `
            .${this.options.name}-${this.options.type} {
              width: ${this.options.size};
              aspect-ratio: 1;
              display: grid;
              border-radius: 50%;
              background:
                linear-gradient(0deg ,${this.hex2rgba(this.options.color, 0.5)} 30%,#0000 0 70%,${this.hex2rgba(this.options.color, 1)} 0) 50%/8% 100%,
                linear-gradient(90deg,${this.hex2rgba(this.options.color, 0.25)} 30%,#0000 0 70%,${this.hex2rgba(this.options.color, 0.75)} 0) 50%/100% 8%;
              background-repeat: no-repeat;
              animation: ${this.options.name}-anim 1s infinite steps(12);
            }
            .${this.options.name}-${this.options.type}::before,
            .${this.options.name}-${this.options.type}::after {
               content: "";
               grid-area: 1/1;
               border-radius: 50%;
               background: inherit;
               opacity: 0.915;
               transform: rotate(30deg);
            }
            .${this.options.name}-${this.options.type}::after {
               opacity: 0.83;
               transform: rotate(60deg);
            }
            @keyframes ${this.options.name}-anim {
              100% {transform: rotate(1turn)}
            }
            `,
            spinner_6: `
            .${this.options.name}-${this.options.type} {
              width: ${this.options.size};
              aspect-ratio: 1;
              border-radius: 50%;
              border: 8px solid ${this.options.color};
              animation:
                ${this.options.name}-anim 0.8s infinite linear alternate,
                ${this.options.name}-anim2 1.6s infinite linear;
            }
            @keyframes ${this.options.name}-anim{
              0%    {clip-path: polygon(50% 50%,0       0,  50%   0%,  50%    0%, 50%    0%, 50%    0%, 50%    0% )}
              12.5% {clip-path: polygon(50% 50%,0       0,  50%   0%,  100%   0%, 100%   0%, 100%   0%, 100%   0% )}
              25%   {clip-path: polygon(50% 50%,0       0,  50%   0%,  100%   0%, 100% 100%, 100% 100%, 100% 100% )}
              50%   {clip-path: polygon(50% 50%,0       0,  50%   0%,  100%   0%, 100% 100%, 50%  100%, 0%   100% )}
              62.5% {clip-path: polygon(50% 50%,100%    0, 100%   0%,  100%   0%, 100% 100%, 50%  100%, 0%   100% )}
              75%   {clip-path: polygon(50% 50%,100% 100%, 100% 100%,  100% 100%, 100% 100%, 50%  100%, 0%   100% )}
              100%  {clip-path: polygon(50% 50%,50%  100%,  50% 100%,   50% 100%,  50% 100%, 50%  100%, 0%   100% )}
            }
            @keyframes ${this.options.name}-anim2 {
              0%    {transform:scaleY(1)  rotate(0deg)}
              49.99%{transform:scaleY(1)  rotate(135deg)}
              50%   {transform:scaleY(-1) rotate(0deg)}
              100%  {transform:scaleY(-1) rotate(-135deg)}
            }
            `,
            spinner_7: `
            .${this.options.name}-${this.options.type} {
              width: ${this.options.size};
              aspect-ratio: 1;
              display:grid;
              -webkit-mask: conic-gradient(from 15deg,#0000,#000);
              animation: ${this.options.name}-anim 1s infinite steps(12);
            }
            .${this.options.name}-${this.options.type},
            .${this.options.name}-${this.options.type}:before,
            .${this.options.name}-${this.options.type}:after{
              background:
                radial-gradient(closest-side at 50% 12.5%,
                 ${this.options.color} 96%,#0000) 50% 0/20% 80% repeat-y,
                radial-gradient(closest-side at 12.5% 50%,
                 ${this.options.color} 96%,#0000) 0 50%/80% 20% repeat-x;
            }
            .${this.options.name}-${this.options.type}:before,
            .${this.options.name}-${this.options.type}:after {
              content: "";
              grid-area: 1/1;
              transform: rotate(30deg);
            }
            .${this.options.name}-${this.options.type}:after {
              transform: rotate(60deg);
            }
            @keyframes ${this.options.name}-anim {
              100% {transform:rotate(1turn)}
            }
            `,
            spinner_8: `
            .${this.options.name}-${this.options.type} {
              width: ${this.options.size};
              aspect-ratio: 1;
              --_c:no-repeat radial-gradient(farthest-side,${this.options.color} 92%,#0000);
              background: 
                var(--_c) top,
                var(--_c) left,
                var(--_c) right,
                var(--_c) bottom;
              background-size: 12px 12px;
              animation: ${this.options.name}-anim 1s infinite;
            }
            @keyframes ${this.options.name}-anim {
              to{transform: rotate(.5turn)}
            }
            `,
            continuous: `
            .${this.options.name}-${this.options.type} {
              width: ${this.options.size};
              height: calc(${this.options.size}/6);
              -webkit-mask: linear-gradient(90deg,${this.options.color} 70%,#0000 0) left/20% 100%;
              background:
               linear-gradient(${this.options.color} 0 0) left -25% top 0 /20% 100% no-repeat
               #ddd;
              animation: ${this.options.name}-anim 1s infinite steps(6);
            }
            @keyframes ${this.options.name}-anim {
              100% {background-position: right -25% top 0}
            }
            `,
            blob_1: `
            .${this.options.name}-${this.options.type} {
              height: ${this.options.size};
              aspect-ratio: 2;
              border: 10px solid ${this.options.background};
              box-sizing: border-box;
              background: 
                radial-gradient(farthest-side,${this.options.color} 98%,#0000) left/calc(${this.options.size} / 2.5) calc(${this.options.size} / 2.5),
                radial-gradient(farthest-side,${this.options.color} 98%,#0000) left/calc(${this.options.size} / 2.5) calc(${this.options.size} / 2.5),
                radial-gradient(farthest-side,${this.options.color} 98%,#0000) center/calc(${this.options.size} / 2.5) calc(${this.options.size} / 2.5),
                radial-gradient(farthest-side,${this.options.color} 98%,#0000) right/calc(${this.options.size} / 2.5) calc(${this.options.size} / 2.5),
                ${this.options.background};
              background-repeat: no-repeat;
              filter: blur(4px) contrast(10);
              animation: ${this.options.name}-anim 1s infinite;
            }
            @keyframes ${this.options.name}-anim {
              100%  {background-position:right,left,center,right}
            }
            `,
            // blob_2: `
            // .${this.options.name}-${this.options.type} {
            //   width: ${this.options.size};
            //   aspect-ratio: 1;
            //   padding: 10px;
            //   box-sizing: border-box;
            //   display: grid;
            //   background: #fff;
            //   filter: blur(5px) contrast(10);
            //   mix-blend-mode: darken;
            // }
            // .${this.options.name}-${this.options.type}:before,
            // .${this.options.name}-${this.options.type}:after{
            //   content: "";
            //   grid-area: 1/1;
            //   width: calc(${this.options.size} / 2.5);
            //   height: calc(${this.options.size} / 2.5);
            //   background: ${this.options.color};
            //   animation: ${this.options.name}-anim 2s infinite;
            // }
            // .${this.options.name}-${this.options.type}:after{
            //   animation-delay: -1s;
            // }
            // @keyframes ${this.options.name}-anim {
            //   0%   {transform: translate(   0,0)}
            //   25%  {transform: translate(100%,0)}
            //   50%  {transform: translate(100%,100%)}
            //   75%  {transform: translate(   0,100%)}
            //   100% {transform: translate(   0,0)}
            // }
            // `,
            flipping_1: `
            .${this.options.name}-${this.options.type} {
              width: ${this.options.size};
              aspect-ratio: 1;
              display: grid;
              grid: 50%/50%;
              color: ${this.options.color};
              --_g: no-repeat linear-gradient(currentColor 0 0);
              background: var(--_g),var(--_g),var(--_g);
              background-size: 50.1% 50.1%;
              animation: 
                ${this.options.name}-anim   1.5s infinite steps(1) alternate,
                ${this.options.name}-anim-0 3s   infinite steps(1);
            }
            .${this.options.name}-${this.options.type}::before {
              content: "";
              background: currentColor;
              transform: perspective(150px) rotateY(0deg) rotateX(0deg);
              transform-origin: bottom right; 
              animation: ${this.options.name}-anim1 1.5s infinite linear alternate;
            }
            @keyframes ${this.options.name}-anim {
              0%  {background-position: 0    100%,100% 100%,100% 0}
              33% {background-position: 100% 100%,100% 100%,100% 0}
              66% {background-position: 100% 0   ,100% 0   ,100% 0}
            }
            @keyframes ${this.options.name}-anim-0 {
              0%  {transform: scaleX(1)  rotate(0deg)}
              50% {transform: scaleX(-1) rotate(-90deg)}
            }
            @keyframes ${this.options.name}-anim1 {
              16.5%{transform:perspective(150px) rotateX(-90deg)  rotateY(0deg)    rotateX(0deg);filter:grayscale(0.8)}
              33%  {transform:perspective(150px) rotateX(-180deg) rotateY(0deg)    rotateX(0deg)}
              66%  {transform:perspective(150px) rotateX(-180deg) rotateY(-180deg) rotateX(0deg)}
              100% {transform:perspective(150px) rotateX(-180deg) rotateY(-180deg) rotateX(-180deg);filter:grayscale(0.8)}
            }
            `,
            flipping_2: `
            .${this.options.name}-${this.options.type} {
              width: ${this.options.size};
              aspect-ratio: 1;
              color: ${this.options.color};
              background:
                linear-gradient(currentColor 0 0) 100%  0,
                linear-gradient(currentColor 0 0) 0  100%;
              background-size: 50.1% 50.1%;
              background-repeat: no-repeat;
              animation:  ${this.options.name}-anim 1s infinite steps(1);
            }
            .${this.options.name}-${this.options.type}::before,
            .${this.options.name}-${this.options.type}::after {
              content:"";
              position: absolute;
              inset: 0 50% 50% 0;
              background: currentColor;
              transform: scale(var(--s,1)) perspective(150px) rotateY(0deg);
              transform-origin: bottom right; 
              animation: ${this.options.name}-anim1 .5s infinite linear alternate;
            }
            .${this.options.name}-${this.options.type}::after {
              --s:-1,-1;
            }
            @keyframes ${this.options.name}-anim {
              0%  {transform: scaleX(1)  rotate(0deg)}
              50% {transform: scaleX(-1) rotate(-90deg)}
            }
            @keyframes ${this.options.name}-anim1 {
              49.99% {transform:scale(var(--s,1)) perspective(150px) rotateX(-90deg) ;filter:grayscale(0)}
              50%    {transform:scale(var(--s,1)) perspective(150px) rotateX(-90deg) ;filter:grayscale(0.8)}
              100%   {transform:scale(var(--s,1)) perspective(150px) rotateX(-180deg);filter:grayscale(0.8)}
            }
            `,
        }
        const styleTag = document.createElement('style');
        styleTag.appendChild(document.createTextNode(styles[this.options.type]));
        return styleTag;
    },
    __generate__loader_content: function () {
        const loaderBar = document.createElement('div');
        loaderBar.classList.add(`${this.options.name}-${this.options.type}`);
        return loaderBar;
    },
    load: function (options = {}) {
        this.__init__(options);
        this.__render__loader();
    },
    remove_loader: function (loader_name, container) {
        const loaderElement = container.querySelector(`.${loader_name}--loader`);
        if (loaderElement) {
            loaderElement.remove();
        }
    },
    loader_exist: function (loader_name, container) {
        const loaderElement = container.querySelector(`.${loader_name}--loader`);
        if (loaderElement) {
            return true;
        }
        return false;
    },
    hex2rgba: (hex, alpha = 1) => {
        const [r, g, b] = hex.match(/\w\w/g).map(x => parseInt(x, 16));
        return `rgba(${r},${g},${b},${alpha})`;
    }
};