var getItemIdFromElement = function($li){
	return $li.attr('id').match(/item-id-(\d+)/)[1];
};

var getOrder = function($ul){
	var $li = $ul.find('li');
	
	var isFirst = function($element){
		return $element.prev().length === 0;
	};
	
	var isLast = function($element){
		return $element.next().length === 0;
	};
	
	var hasChildren = function($element){
		return $element.find('> ul > li:first').length === 1;
	};
	
	var checkDepth = function($start, selector){
		var level = 0;
		
		while (true) {
			$start = $start.find(selector);
			
			if ($start.length !== 0) {
				level++;
			} else {
				break;
			}
		}
		
		return level;
	};
	
	var level = -1,
		parents = [0],	// parents[level] = parent_id
		prevWasLastSibling = false,
		data = [];
	
	$li.each(function(){
		var $self = $(this);
		
		if (prevWasLastSibling) {
			level -= checkDepth($self.prev(), '> ul > li:last');
			prevWasLastSibling = false;
			
		} else if (isFirst($self)) {
			level++;
		}
		
		data.push({
			level: level,
			parent: parents[level],
			id: getItemIdFromElement($self)
		});
		
		if (hasChildren($self)) {
			parents[level + 1] = getItemIdFromElement($self);
			
		} else if (isLast($self)) {		// Don't evaluate if hasChildren
			prevWasLastSibling = true;
		}
	});
	
	return data;
};