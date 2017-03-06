import React, { Component, PropTypes } from 'react';
import { connect } from 'react-redux';
import { Field, reduxForm } from 'redux-form';
import { updatePundit } from '../actions/actions-pundits';
import { Link } from 'react-router';

class AddPunditForm extends Component {

	static contextTypes = {
		router: PropTypes.object
	};

	componentDidMount() {
		this.handleInitialize();
	}

	handleInitialize() {

		const { firstname, surname } = this.props.pundit;

		const initialData = {
			"firstname": firstname,
			"surname": surname,
		};

		this.props.initialize(initialData);
	}

	handleSubmit = ( values ) => {
		this.props.updatePundit( { ...values, id: this.props.params.id } )
		  .then(() => {
			  this.context.router.push('/');
		  });
	};

	render() {

		const { handleSubmit, pristine, submitting } = this.props;

		if ( null === this.props.pundit ) {
			return <div>Loading...</div>
		}

		return <div>
			<form onSubmit={handleSubmit(this.handleSubmit)}>

				<div>
					<label htmlFor="firstname">First Name</label>
					<Field name="firstname" component="input" type="text"/>
				</div>
				<div>
					<label htmlFor="surname">Last Name</label>
					<Field name="surname" component="input" type="text"/>
				</div>

				<button type="submit" disabled={pristine || submitting}>Update Pundit</button>
			</form>

			<Link to="/">Back to Pundits</Link>
		</div>
	}
}

let addPunditForm = reduxForm({
	form: 'AddPunditForm',
	// validate
})(AddPunditForm);

const mapStateToProps = (state) => {
	return { pundit: state.pundits.selected };
};

export default connect( mapStateToProps, { updatePundit } )( addPunditForm );