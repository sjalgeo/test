import React from 'react';
import { Route, IndexRoute } from 'react-router';
import PunditList from './components/PunditList';
import EditPundit from './components/EditPundit';
import AddPundit from './components/AddPundit';

export default (
  <Route path="/">
	  <IndexRoute component={PunditList} />
	  <Route path="edit/:id" component={EditPundit} />
	  <Route path="add" component={AddPundit} />
  </Route>
);