import * as React from 'react';
import { Layout } from 'react-admin';
import {AdminAppBar} from "./AdminAppBar";

export const AdminLayout = (props) => <Layout {...props} appBar={AdminAppBar} />;
