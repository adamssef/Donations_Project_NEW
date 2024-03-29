document.addEventListener("DOMContentLoaded", function () {
    /**
     * Form Select
     */
    class FormSelect {
        constructor($el) {
            this.$el = $el;
            this.options = [...$el.children];
            this.init();
        }

        init() {
            this.createElements();
            this.addEvents();
            this.$el.parentElement.removeChild(this.$el);
        }

        createElements() {
            // Input for value
            this.valueInput = document.createElement("input");
            this.valueInput.type = "text";
            this.valueInput.name = this.$el.name;

            // Dropdown container
            this.dropdown = document.createElement("div");
            this.dropdown.classList.add("dropdown");

            // List container
            this.ul = document.createElement("ul");

            // All list options
            this.options.forEach((el, i) => {
                const li = document.createElement("li");
                li.dataset.value = el.value;
                li.innerText = el.innerText;

                if (i === 0) {
                    // First clickable option
                    this.current = document.createElement("div");
                    this.current.innerText = el.innerText;
                    this.dropdown.appendChild(this.current);
                    this.valueInput.value = el.value;
                    li.classList.add("selected");
                }

                this.ul.appendChild(li);
            });

            this.dropdown.appendChild(this.ul);
            this.dropdown.appendChild(this.valueInput);
            this.$el.parentElement.appendChild(this.dropdown);
        }

        addEvents() {
            this.dropdown.addEventListener("click", e => {
                const target = e.target;
                this.dropdown.classList.toggle("selecting");

                // Save new value only when clicked on li
                if (target.tagName === "LI") {
                    this.valueInput.value = target.dataset.value;
                    this.current.innerText = target.innerText;
                }
            });
        }
    }

    document.querySelectorAll(".form-group--dropdown select").forEach(el => {
        new FormSelect(el);
    });

    /**
     * Hide elements when clicked on document
     */
    document.addEventListener("click", function (e) {
        const target = e.target;
        const tagName = target.tagName;

        if (target.classList.contains("dropdown")) return false;

        if (tagName === "LI" && target.parentElement.parentElement.classList.contains("dropdown")) {
            return false;
        }

        if (tagName === "DIV" && target.parentElement.classList.contains("dropdown")) {
            return false;
        }

        document.querySelectorAll(".form-group--dropdown .dropdown").forEach(el => {
            el.classList.remove("selecting");
        });
    });

    /**
     * Switching between form steps
     */
    class FormSteps {
        constructor(form) {
            this.$form = form;
            this.$next = form.querySelectorAll(".next-step");
            this.$prev = form.querySelectorAll(".prev-step");
            this.$step = form.querySelector(".form--steps-counter span");
            this.currentStep = 1;

            this.$stepInstructions = form.querySelectorAll(".form--steps-instructions p");
            const $stepForms = form.querySelectorAll("form > div");
            this.slides = [...this.$stepInstructions, ...$stepForms];

            this.init();
        }

        /**
         * Init all methods
         */
        init() {
            this.events();
            this.updateForm();
        }

        /**
         * All events that are happening in form
         */
        events() {
            // Next step
            this.$next.forEach(btn => {
                btn.addEventListener("click", e => {
                    e.preventDefault();
                    this.currentStep++;
                    this.updateForm();
                });
            });

            // Previous step
            this.$prev.forEach(btn => {
                btn.addEventListener("click", e => {
                    e.preventDefault();
                    this.currentStep--;
                    this.updateForm();
                });
            });

            // Form submit
            this.$form.querySelector("form").addEventListener("submit", e => this.submit(e));
        }

        /**
         * Update form front-end
         * Show next or previous section etc.
         */
        updateForm() {
            this.$step.innerText = this.currentStep;

            // TODO: Validation

            this.slides.forEach(slide => {
                slide.classList.remove("active");

                if (slide.dataset.step == this.currentStep) {
                    slide.classList.add("active");
                }
            });

            this.$stepInstructions[0].parentElement.parentElement.hidden = this.currentStep >= 5;
            this.$step.parentElement.hidden = this.currentStep >= 5;

            // TODO: get data from inputs and show them in summary
        }

    }

    const form = document.querySelector(".form--steps");
    if (form !== null) {
        new FormSteps(form);
    }


    /**
     * donation summary
     */


    document.getElementById('goToSummary').addEventListener('click', function () {
        //(1)get array of all selected categories
        let dataStepFirstElements = document.querySelectorAll('[data-step = "1"]')[1].getElementsByClassName("form-group--checkbox");
        let categoryCollection = document.getElementsByClassName('one_category');
        let categoriesSelected = [];
        for (i = 0; i < dataStepFirstElements.length; i++) {
            if (dataStepFirstElements[i].childNodes[1].childNodes[1].checked === true) {
                let category = categoryCollection[i].childNodes[0].innerText;
                categoriesSelected.push(category);
            }
        }
        //(2) get number of donation bags
        let numberOfBagsCollection = document.getElementsByClassName('form-group form-group--inline');
        let numberOfBags = numberOfBagsCollection[1].children[0].children[0].value;
        let numberOfBagsToDisplay = numberOfBags + " worków.";


        //(3)get organization that was selected
        let organizationCollection = document.getElementsByName("donation[institution]");
        let selectedOrg;
        for (i = 0; i < organizationCollection.length; i++) {
            if (organizationCollection[i].checked === true) {
                selectedOrg = organizationCollection[i].parentElement.parentElement.previousElementSibling.children[0].innerHTML;
            }
        }

        //(4) get and set date and time
        let date = [];
        let date2 = String(document.getElementById("donation_pickUpDate").value);
        // let month = String(document.getElementById("donation_pickUpDate_month").value);
        // let day = String(document.getElementById("donation_pickUpDate_day").value);
        date2exploaded = date2.split('-');

        let year = date2exploaded[0];
        let month = date2exploaded[1];
        let day = date2exploaded[2];

        let time2 = String(document.getElementById("donation_pickUpTime").value);
        let time2exploaded = time2.split(':');
        let hour = time2exploaded[0];
        let minutes = time2exploaded[1];
        // let minutes = String(document.getElementById("donation_pickUpTime_minute").value);
        date.push([year, month, day]);
        // dateString = date[0] + "\-" + date[1] + "\-" + date[2];
        dateTime = new Date(year, month - 1, [day]);
        dateTime.setHours(hour, minutes);
        let options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: 'numeric',
            minute: 'numeric'
        };
        dateFormatted = dateTime.toLocaleDateString('pl-PL', options);
        timeFormatted = hour + ":" + minutes;

        document.getElementById('pickUpDate').innerHTML = dateFormatted;


        //(5)set summary number of bags
        document.getElementById('numberOfBags2').nextElementSibling.innerHTML = numberOfBagsToDisplay;
        //(6)set summary organisations selected
        document.getElementById('organisation').nextElementSibling.innerHTML = selectedOrg;

        //(6) get and set street
        let street = document.getElementsByName('donation[street]')[0].value;
        document.getElementById('street').innerHTML = street;


        //(7) get  and set city
        let city = document.getElementsByName('donation[city]')[0].value;
        document.getElementById('city').innerHTML = city;

        //(8) get and set zip code
        let zipCode = document.getElementsByName('donation[zipCode]')[0].value;
        document.getElementById('zipCode').innerHTML = zipCode;
        //(9) get and set comment for courier
        let comment = document.getElementsByName('donation[pickUpComment]')[0].value;

        document.getElementById('pickUpComment').innerHTML = comment;
    });

    /*
    Making sure all steps are completed
     */
    let nextStepButtons = document.getElementsByClassName('btn next-step');

    function stepVerifier(element, nextStepsButtons) {
        const events = ['mousedown', 'keypress'];

        switch (element.parentElement.parentElement.dataset.step) {
            //(1)checks if there are any checkboxes checked during step one
            case "1":
                //(a)form is submitted via mouse or touchpad or enter
                let stepOneNextStepBtn = [...nextStepsButtons][0];
                stepOneNextStepBtn.disabled = false;

                events.forEach(function (e) {
                    stepOneNextStepBtn.addEventListener(e, function () {
                        if (event.code === "Enter" || e === 'mousedown') {
                            let stepOne = element.parentElement.parentElement;
                            let [...stepOneInputs] = stepOne.getElementsByTagName("INPUT");
                            let i = 0;
                            stepOneInputs.forEach(function (input) {
                                if (input.checked === true) {
                                    i++;
                                }
                            });

                            if (i === 0) {
                                stepOneNextStepBtn.disabled = true;
                                Swal.fire("Proszę zaznaczyć co najmniej jedno pole");
                                setTimeout(function () {
                                    stepOneNextStepBtn.disabled = false;
                                }, 800)
                            }
                        }

                    });
                });

                break;
            //(2)checks if there is number of bags provided
            case "2":
                let stepTwoNextStepBtn = [...nextStepsButtons][1];
                stepTwoNextStepBtn.disabled = false;

                events.forEach(function (e) {
                    stepTwoNextStepBtn.addEventListener(e, function () {
                        let stepTwoInput = $('#donation_quantity')[0].value;
                        if (event.code === "Enter" || e === 'mousedown') {
                            if (stepTwoInput === 0 || typeof (stepTwoInput) === undefined || stepTwoInput === "") {
                                stepTwoNextStepBtn.disabled = true;
                                Swal.fire("Proszę wpisz ilość worków:)");
                                setTimeout(function () {
                                    stepTwoNextStepBtn.disabled = false;
                                }, 800)
                            }
                        }
                    });
                });
                break;
            //(3)checks if there is a radio button checked
            case "3":
                let stepThreeNextStepBtn = [...nextStepsButtons][2];
                stepThreeNextStepBtn.disabled = false;

                events.forEach(function (e) {
                    stepThreeNextStepBtn.addEventListener(e, function () {
                        if (event.code === "Enter" || e === 'mousedown') {
                            let stepThree = element.parentElement.parentElement;

                            let [...inputs] = stepThree.getElementsByTagName("INPUT");
                            let i = 0;
                            inputs.forEach(function (input) {
                                if (input.checked === true) {
                                    i++;
                                }
                            });

                            if (i === 0) {
                                stepThreeNextStepBtn.disabled = true;
                                Swal.fire({
                                    title: "Wybierz organizację, którą wspierasz",
                                    type:"warning",
                                });
                                setTimeout(function () {
                                    stepThreeNextStepBtn.disabled = false;
                                }, 800)
                            }
                        }
                    });
                });

                break;

            //TODO implement case "4"
            //(4)checks if all the fields are completed (except comment as it is not mandatory)
            case "4":
                let stepFourNextStepBtn = [...nextStepsButtons][3];
                let stepFour = element.parentElement.parentElement;
                let [...stepFourInputs] = stepFour.getElementsByTagName('INPUT');
                stepFourInputs.pop();

                events.forEach(function (e) {
                    stepFourNextStepBtn.addEventListener(e, function () {
                        if (event.code === "Enter" || e === 'mousedown') {
                            let i = 0;
                            let emptyStepFourFields = [];
                            stepFourInputs.forEach(function (input) {
                                input.required = true;
                                if (input.value === "") {
                                    i++;
                                }

                                emptyStepFourFields.push(input.id);
                            });
                            emptyStepFourFieldsStrModified = [];
                            emptyStepFourFields.forEach(field=> {
                                let element =  field.split('_');
                                element.shift();
                                element = element[0].replace(/([A-Z])/g, ' $1');
                                field = element;
                                emptyStepFourFieldsStrModified.push(field);
                            });
                            let communicateStart = '<ul>';
                            emptyStepFourFieldsStrModified.forEach(e=>{
                                communicateStart = communicateStart.concat('<li style="font-size: large">'+e+'</li>;');
                            });

                            communicateStart.concat('</ul>');

                            console.log(communicateStart);



                            if (i !== 0) {
                                stepFourNextStepBtn.disabled = true;
                                Swal.fire({
                                    type: 'warning',
                                    title: "PROSZĘ ZAZNACZ WSZYSTKIE POTRZEBNE POLA",
                                    html: communicateStart,
                                });
                                setTimeout(function () {
                                    stepFourNextStepBtn.disabled = false;
                                }, 800)
                            }
                        }
                    });
                });
        }
    }


    //Adding event listener on next step buttons
    [...nextStepButtons].forEach(function (element) {
        element.addEventListener('click', stepVerifier(element, nextStepButtons));
    })

});


