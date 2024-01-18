/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import {
	useBlockProps,
	RichText,
	InspectorControls
} from '@wordpress/block-editor';
import { PanelBody, SelectControl } from "@wordpress/components";
import { useSelect } from "@wordpress/data";

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
import metadata from './block.json';

export default function Edit(props) {
	const postTypes = useSelect((select) => {
		const data = select("core").getEntityRecords("root", "postType", {
			per_page: -1,
		});
		return data?.filter(
			(item) => item.visibility.show_in_nav_menus && item.visibility.show_ui
		);
	});
	console.log(postTypes)

	const blockProps = useBlockProps();

	return (
		<>
			<InspectorControls>
				<PanelBody title={__('Destination', metadata.textdomain)}>
					<SelectControl
						label={__('Type', metadata.textdomain)}
						value={props.attributes.postType}
						onChange={(newValue) => {
							props.setAttributes({
								postType: newValue,
							});
						}}
						options={[
							{
								label: __('Select a post type...', metadata.textdomain),
								value: ''
							}, ...(postTypes || []).map((postType) => ({
								label: postType.labels.singular_name,
								value: postType.slug
							}))
						]}
					/>
				</PanelBody>
			</InspectorControls>
			<div {...blockProps}>
				<RichText
					placeholder={__('Label text', metadata.textdomain)}
					value={props.attributes.labelText}
					allowedFormats={[]}
					multiline={false}
					onSplit={() => { }}
					onReplace={() => { }}
					onChange={(newValue) => {
						props.setAttributes({
							labelText: newValue,
						});
					}}
				/>
			</div>
		</>
	);
}
