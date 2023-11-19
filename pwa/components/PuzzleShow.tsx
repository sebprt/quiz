import { Show, TabbedShowLayout, TextField, ReferenceArrayField, Datagrid, NumberField,  BooleanField } from 'react-admin'
import PieceDatagrid from "./PieceDatagrid";

const PuzzleShow = props => (
  <Show {...props}>
    <TabbedShowLayout>
      <TabbedShowLayout.Tab label="summary">
        <TextField source="name" />
        <TextField source="imageUrl" />
      </TabbedShowLayout.Tab>
      <TabbedShowLayout.Tab label="Pieces" path="body">
        <PieceDatagrid />
      </TabbedShowLayout.Tab>
    </TabbedShowLayout>
  </Show>
);

export default PuzzleShow
