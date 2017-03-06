import React, { Component, PropTypes } from 'react';
import { connect } from 'react-redux';
import { fetchPundits, updatePundit, selectPundit, deletePundit, resetPundits } from '../actions/actions-pundits';
import { Link } from 'react-router';

class PunditList extends Component {

	static contextTypes = {
		router: PropTypes.object
	};

	constructor() {
		super();
		this.renderRow = this.renderRow.bind(this);
		this.editPundit = this.editPundit.bind(this);
		this.deletePundit = this.deletePundit.bind(this);
		this.resetPundits = this.resetPundits.bind(this);
	}

	componentWillMount() {
		this.props.fetchPundits();
	}

	editPundit( id ) {
		this.props.selectPundit(id);
		this.context.router.push('edit/' + id );
	}

	deletePundit( id ) {
		this.props.deletePundit(id)
		  .then( this.props.fetchPundits );
	}

	resetPundits() {
		this.props.resetPundits()
		  .then( this.props.fetchPundits );
	}

	renderRow( pundit, key ) {
		return <tr key={key}>
			<td>{pundit.firstname + ' ' + pundit.surname}</td>
			<td><button onClick={this.editPundit.bind(null, pundit.id)}>Edit</button> </td>
			<td><button onClick={this.deletePundit.bind(null, pundit.id)}>Delete</button> </td>
		</tr>
	};

	renderPundits() {
		return this.props.pundits.map( this.renderRow )
	}

	render() {
		return <div>
			<span>These are the pundits...</span>
			<table>
				<tbody>
				{this.renderPundits()}
				</tbody>
			</table>

			<Link to="add">Add New Pundit</Link>
			<button onClick={this.resetPundits}>Reset to Default</button>
		</div>
	}
}

const mapStateToProps = (state) => {
	const { all } = state.pundits;
	return { pundits: all };
};

export default connect( mapStateToProps, { resetPundits, fetchPundits, updatePundit, selectPundit, deletePundit } )( PunditList );