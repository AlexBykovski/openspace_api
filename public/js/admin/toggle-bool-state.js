class ToggleBoolState {
    constructor(container) {
        this.container = container;

        this.elements = {
            trueValue: this.container.querySelector('.js-true-value'),
            falseValue: this.container.querySelector('.js-false-value'),
        }
        this.url = container.dataset.url;
        this.id = container.dataset.id;
        this.field = container.dataset.field;
        this.state = container.dataset.initValue === 'true';

        this.#init();
    }

    #init() {
        this.#setEventListeners();
    }

    #setEventListeners() {
        this.elements.trueValue.addEventListener('click', () => this.#handleToggleBool(this))
        this.elements.falseValue.addEventListener('click', () => this.#handleToggleBool(this))
    }

    #handleToggleBool(self) {
        HttpRequest.postRequest(
            self.url,
            (res) => {
                res = JSON.parse(res);

                if (res.success) {
                    self.#hideShowElement();

                    self.state = !self.state;
                }
            },
            (error) => console.error('Error due request'),
            {
                field: self.field
            }
        )
    }

    #hideShowElement() {
        if (this.state) {
            this.elements.trueValue.style.display = 'none';
            this.elements.falseValue.style.display = 'inline';
        } else {
            this.elements.trueValue.style.display = 'inline';
            this.elements.falseValue.style.display = 'none';
        }
    }
}

document.addEventListener("DOMContentLoaded", (event) => {
    document.querySelectorAll('.js-toggle-bool').forEach((el) => {
        if (!window.toggleBoolStateObjects) window.toggleBoolStateObjects = {};

        window.toggleBoolStateObjects[el.dataset.id] = new ToggleBoolState(el);
    });
});
