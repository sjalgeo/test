import React from 'react';
import { Route, IndexRoute } from 'react-router';
import PunditList from './components/PunditList';
import EditPage from './components/EditPage';

export default (
  <Route path="/">
	  <IndexRoute component={PunditList} />
	  <Route path="edit" component={EditPage} />
  </Route>
);