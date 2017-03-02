import React from 'react';
import { Component } from 'react';
import { connect } from 'react-redux';

class EditPage extends Component {

	render() {

		return <div>
			Pundit List
		</div>
	}
}

// let domain_form = reduxForm({
//     form: 'wizard',
//     destroyOnUnmount: false,
//     forceUnregisterOnUnmount: true,
//     validate
// })(EditPage);

const mapStateToProps = (state) => {
	// const { text, type } = state.feedback;
	// return { type, text };
	// return
};

export default connect( mapStateToProps, {} )( EditPage );