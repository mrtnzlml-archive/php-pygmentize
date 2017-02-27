<?php declare(strict_types = 1);

namespace Adeira\Formatter;

final class Html implements \Adeira\IFormatter
{

	private $allowedTokens = [
		'Text',
		'Whitespace',
		'Escape',
		'Error',
		'Other',
		'Keyword',
		'Keyword.Constant',
		'Keyword.Declaration',
		'Keyword.Namespace',
		'Keyword.Pseudo',
		'Keyword.Reserved',
		'Keyword.Type',
		'Name',
		'Name.Attribute',
		'Name.Builtin',
		'Name.Builtin.Pseudo',
		'Name.Class',
		'Name.Constant',
		'Name.Decorator',
		'Name.Entity',
		'Name.Exception',
		'Name.Function',
		'Name.Function.Magic',
		'Name.Property',
		'Name.Label',
		'Name.Namespace',
		'Name.Other',
		'Name.Tag',
		'Name.Variable',
		'Name.Variable.Class',
		'Name.Variable.Global',
		'Name.Variable.Instance',
		'Name.Variable.Magic',
		'Literal',
		'Literal.Date',
		'String',
		'String.Affix',
		'String.Backtick',
		'String.Char',
		'String.Delimiter',
		'String.Doc',
		'String.Double',
		'String.Escape',
		'String.Heredoc',
		'String.Interpol',
		'String.Other',
		'String.Regex',
		'String.Single',
		'String.Symbol',
		'Number',
		'Number.Bin',
		'Number.Float',
		'Number.Hex',
		'Number.Integer',
		'Number.Integer.Long',
		'Number.Oct',
		'Operator',
		'Operator.Word',
		'Punctuation',
		'Comment',
		'Comment.Hashbang',
		'Comment.Multiline',
		'Comment.Preproc',
		'Comment.PreprocFile',
		'Comment.Single',
		'Comment.Special',
		'Generic',
		'Generic.Deleted',
		'Generic.Emph',
		'Generic.Error',
		'Generic.Heading',
		'Generic.Inserted',
		'Generic.Output',
		'Generic.Prompt',
		'Generic.Strong',
		'Generic.Subheading',
		'Generic.Traceback',
	];

	public function format(string $fragment, string $type): string
	{
		if (!in_array($type, $this->allowedTokens, TRUE)) { //FIXME: speciální Error
			throw new \Exception("Token '$type' doesn't exist."); //FIXME: jak lépe?
		}

		if (!$fragment || preg_match('~^\s$~', $fragment)) { //do not polute output with empty tags
			return $fragment;
		}

		$type = preg_replace('~\.~', ' ', $type);
		return "<span class='$type'>" . htmlspecialchars($fragment) . '</span>';
	}

}
