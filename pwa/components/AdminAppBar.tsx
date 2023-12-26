import * as React from 'react';
import { AppBar, TitlePortal, Typography } from 'react-admin';
import Box from '@mui/material/Box';

const AdminAppBar = () => (
  <AppBar position="sticky">
    <TitlePortal />
    <Box flex="1" />
    <Typography>Quiz</Typography>
    <Box flex="1" />
  </AppBar>
);

export default AdminAppBar
