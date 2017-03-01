import React from 'react';
import { Component } from 'react';
import { connect } from 'react-redux';
import { fetchPundits } from '../actions/actions-pundits';

class PunditList extends Component {

	componentWillMount() {
		this.props.fetchPundits();
	}

	renderPundits() {
		const rows = (pundit, key) => <tr key={key}><td>{pundit.firstname + ' ' + pundit.surname}</td></tr>

		return this.props.pundits.map(rows)
	}

	render() {
		return <div>
			<table>
				<tbody>
				{this.renderPundits()}
				</tbody>
			</table>
		</div>
	}
}

const mapStateToProps = (state) => {
	const { pundits } = state;
	return { pundits };
};

export default connect( mapStateToProps, { fetchPundits } )( PunditList );