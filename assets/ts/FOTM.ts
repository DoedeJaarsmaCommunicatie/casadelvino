class fotmProps {
	public target : string | undefined;
}

class FOTM {
	props: fotmProps;

	constructor(props: fotmProps) {
		this.props = props;
		this.run();
	}

	async run() {
		const isFrontpage = await this.isFrontpage();

		if (!this.isFrontpage()) {
			return;
		}


		if (!this.props.target) {
			throw new Error('Target not set!')
		}
	}

	async isFrontpage(): Promise<boolean> {
		return new Promise(((resolve, reject) => {
			const body = <HTMLElement> document.querySelector('body');

			if(body.classList.contains('home')) {
				resolve(true)
			}
			resolve(false);
		}));
	}

	async addElement(): Promise<void> {
		return new Promise((resolve, reject) => {
			const fotm = document.querySelector(this.props.target);

			try {
				fotm.insertAdjacentHTML('beforeend', this.flavourElement());
				resolve();
			} catch ( e ) {
				reject(e)
				throw new Error(e);
			}
		});
	}

	flavourElement(): string {
		const element = `
		<div class="fotm-banner text-white bg-primary">
			Wijn van de maand
		</div>`;
		return element;
	}
}

document.addEventListener('DOMContentLoaded', () => {
	new FOTM({
		target: `[data-extra="monthly"]`
	});
});

