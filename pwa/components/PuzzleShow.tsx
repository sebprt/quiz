import { Show, TabbedShowLayout, TextField, ReferenceArrayField, Datagrid, NumberField,  BooleanField } from 'react-admin'
import PieceList from "./PieceList";

const PuzzleShow = props => (
  <Show {...props}>
    <TabbedShowLayout>
      <TabbedShowLayout.Tab label="summary">
        <TextField source="name" />
        <TextField source="imageUrl" />
      </TabbedShowLayout.Tab>
      <TabbedShowLayout.Tab label="Pieces" path="pieces">
        <PieceList />
      </TabbedShowLayout.Tab>
    </TabbedShowLayout>
  </Show>
);

export default PuzzleShow
