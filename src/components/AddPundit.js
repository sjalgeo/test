import React, { Component, PropTypes } from 'react';
import { connect } from 'react-redux';
import { Field, reduxForm } from 'redux-form';
import { createPundit } from '../actions/actions-pundits';
import { Link } from 'react-router';

class AddPunditForm extends Component {

	static contextTypes = {
		router: PropTypes.object
	};

	handleSubmit = ( values ) => {
		this.props.createPundit( values )
		  .then(() => {
			  this.context.router.push('/');
		  });
	};

	render() {

		const { handleSubmit, pristine, submitting } = this.props;

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

				<button type="submit" disabled={pristine || submitting}>Add New Pundit</button>
			</form>

			<Link to="/">Back to Pundits</Link>
		</div>
	}
}

let addPunditForm = reduxForm({
    form: 'AddPunditForm',
    // validate
})(AddPunditForm);

export default connect( null, { createPundit } )( addPunditForm );